<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * Studies Controller
 *
 * @property \App\Model\Table\StudiesTable $Studies
 */
class StudiesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        // 検索フォーム
        // 技術書プルダウンの初期値
        $searchBooks = $this->_getfirstBook();
        if ($this->request->is('post')) {
            $searchBooks = $this->request->data['books'];
        }
        // 技術書一覧をプルダウンで取得
        $arrBooks = TableRegistry::get('Books')
            ->find()
            ->select(['id', 'display_order', 'title'])
            ->order(['books.display_order' => 'ASC']);
        foreach ($arrBooks as $value) {
            $selectBooks[$value['id']] = $value['display_order'] . ". " . $value['title'];
        }
        $this->set(compact('selectBooks','searchBooks'));

        $this->paginate = [
            'limit' => 300,
            'maxLimit' => 300,
            'sortWhitelist' => [
                'Books.display_order',
                'BigChapters.display_order',
                'MiddleChapters.display_order',
                'display_order'
            ],
            'order' => [
                'Books.display_order' => 'asc',
                'BigChapters.display_order' => 'asc',
                'MiddleChapters.display_order' => 'asc',
                'display_order' => 'asc'
            ],
            'contain' => [
                'Users',
                'Statuses',
                'SmallChapters' => [
                    'MiddleChapters' => [
                        'BigChapters' => [
                            'Books'
                        ]
                    ]
                ]
            ]
        ];
        $studies = $this->paginate(
            $this->Studies
            ->find()
            ->where("Books.id = $searchBooks")
            ->order([
                'studies.created' => 'DESC'
            ])
        );

        $this->set(compact('studies'));
        $this->set('_serialize', ['studies']);
    }

    /**
     * View method
     *
     * @param string|null $id Study id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $study = $this->Studies->get($id, [
            'contain' => ['Users', 'SmallChapters', 'Statuses']
        ]);

        $this->set('study', $study);
        $this->set('_serialize', ['study']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // 技術書検索フォーム
        $searchBooks = $this->_getfirstBook();
        $BigChapters = TableRegistry::get('BigChapters');
        if ($this->request->is('post')) {
            $searchBooks = $this->request->data['books'];
        }
        $bChapter_cnt = TableRegistry::get('BigChapters')
            ->find('all', ['contain' =>['Books']])
            ->where("Books.id = $searchBooks")
            ->count();
        $study_cnt = $this->Studies
            ->find('all', ['contain' => ['SmallChapters' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]])
            ->where("Books.id = $searchBooks")
            ->where('Studies.laps = '.$this->_getLaps($searchBooks))
            ->count();
        $searchBigChapters = $BigChapters
            ->find('all',['contain'=>['Books']])
            ->where("books.id = $searchBooks")
            ->order(['books.laps' => 'DESC'])
            ->order(['BigChapters.display_order'=>'ASC'])
            ->first()->id;
        if ($bChapter_cnt !== 0 && $study_cnt !== 0) {
            $searchBigChapters = $this->Studies
                ->find('all', ['contain' => ['SmallChapters' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]])
                ->select(['BigChapters.id'])
                ->where("books.id = $searchBooks")
                ->where("Studies.laps = ".$this->_getLaps($searchBooks))
                ->order(['Studies.created' => 'DESC'])
                ->first()->BigChapters->id;
        }
        if (isset($this->request->data['big_chapters_flg']) && $this->request->data['big_chapters_flg'] === '1') {
            $searchBigChapters = $this->request->data['big_chapters'];
        }

        // 登録処理
        $study = $this->Studies->newEntity();
        if ($this->request->is('post') && empty($this->request->data['search'])) {
            $this->request->data['laps'] = $this->_getLaps($searchBooks);
            $study = $this->Studies->patchEntity($study, $this->request->data);
            if ($this->Studies->save($study)) {
                $this->Flash->success(__('The study has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The study could not be saved. Please, try again.'));
        }

        // 技術書検索
        $arrBooks = TableRegistry::get('Books')
            ->find()
            ->select(['id', 'display_order', 'title'])
            ->order(['books.display_order' => 'ASC']);
        foreach ($arrBooks as $value) {
            $selectBooks[$value['id']] = $value['display_order'] . ". " . $value['title'];
        }
        // 大分類検索
        $arrBigChapters = TableRegistry::get('BigChapters')
            ->find('all',['contain'=>['Books']])
            ->select(['id', 'display_order', 'title'])
            ->where("books.id = $searchBooks")
            ->order(['BigChapters.display_order' => 'ASC']);
        foreach ($arrBigChapters as $value) {
            $selectBigChapters[$value['id']] = $value['display_order'] . ". " . $value['title'];
        }

        // 小分類
        $arrSmallChapters = TableRegistry::get('SmallChapters')
            ->find('all', ['contain' => ['MiddleChapters' => ['BigChapters' => ['Books']]]])
            ->select(['id', 'display_order', 'title', 'MiddleChapters.id', 'MiddleChapters.title', 'MiddleChapters.display_order'])
            ->where("books.id = $searchBooks")
            ->where("BigChapters.id = $searchBigChapters")
            ->order(['MiddleChapters.display_order' => 'ASC'])
            ->order(['SmallChapters.display_order' => 'ASC']);
        foreach ($arrSmallChapters as $value) {
            $selectSmallChapters[$value['middle_chapter']['display_order'] . '. ' . $value['middle_chapter']['title']][$value['id']] = $value['display_order'] . ". " . $value['title'];
            $jsonSmallChapters[] = $value['id'];
        }
        $jsonSmallChapters = json_encode($jsonSmallChapters, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

        $searchSmallChapters = $this->_getSmallChapters($searchBooks,$study_cnt);

        $this->set(compact(
            'selectBooks',
            'searchBooks',
            'selectBigChapters',
            'searchBigChapters',
            'selectSmallChapters',
            'jsonSmallChapters',
            'searchSmallChapters'
        ));

        $users = $this->Studies->Users->find('list', ['limit' => 200]);
        $smallChapters = $this->Studies->SmallChapters->find('list', ['limit' => 200]);
        $obj_statuses = TableRegistry::get('Statuses')
            ->find()
            ->select(['id','title'])
            ->order(['display_order' => 'ASC']);
        foreach ($obj_statuses as $value) {
            $statuses[$value['id']] = $value['title'];
        }
        $this->set(compact('study', 'users', 'smallChapters', 'statuses'));
        $this->set('_serialize', ['study']);
    }

    private function _getSmallChapters($searchBooks,$study_cnt)
    {
        $sChapter_cnt = $this->Studies
            ->find('all', ['contain' => ['SmallChapters' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]])
            ->where("Books.id = {$searchBooks}")
            ->where('Studies.laps = '.$this->_getLaps($searchBooks))
            ->count();
        if ($sChapter_cnt !== 0 && $study_cnt !== 0) {
            return $this->Studies
                ->find('all', ['contain' => ['SmallChapters' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]])
                ->select(['SmallChapters.id'])
                ->where("books.id = {$searchBooks}")
                ->order(['Studies.created' => 'DESC'])
                ->first()->SmallChapters->id;
        }
        return $searchSmallChapters = TableRegistry::get('SmallChapters')
            ->find('all', ['contain'=>['MiddleChapters'=>['BigChapters'=>['Books']]]])
            ->select(['id'])
            ->where("Books.id = {$searchBooks}")
            ->order(['BigChapters.display_order' => 'ASC'])
            ->order(['MiddleChapters.display_order' => 'ASC'])
            ->order(['SmallChapters.display_order' => 'ASC'])
            ->first()->id;
    }

    /**
     * Edit method
     *
     * @param string|null $id Study id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $study = $this->Studies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $study = $this->Studies->patchEntity($study, $this->request->data);
            if ($this->Studies->save($study)) {
                $this->Flash->success(__('The study has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The study could not be saved. Please, try again.'));
        }
        $users = $this->Studies->Users->find('list', ['limit' => 200]);
        $smallChapters = $this->Studies->SmallChapters->find('list', ['limit' => 200]);
        $statuses = $this->Studies->Statuses->find('list', ['limit' => 200]);
        $this->set(compact('study', 'users', 'smallChapters', 'statuses'));
        $this->set('_serialize', ['study']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Study id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $study = $this->Studies->get($id);
        if ($this->Studies->delete($study)) {
            $this->Flash->success(__('The study has been deleted.'));
        } else {
            $this->Flash->error(__('The study could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * グラフ表示
     */
    public function graph(){

    }

    public function drawgraph(){
        $this->viewBuilder()->layout(false);
        $start_date = new Time($this->request->data['start_date']);
        $end_date = new Time($this->request->data['end_date']);
        $date_diff = ($end_date->toUnixString() - $start_date->toUnixString()) / (24 * 60 * 60);

        for ($i = 0; $i <= $date_diff; $i++){
            $studies_subquery = $this->Studies
                ->find('all', ['contain' => ['SmallChapters' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]])
                ->where("Studies.created <= '{$start_date->format('Y-m-d')}'");
            $studies_subquery
                ->select(['Books.id', 'count' => $studies_subquery->func()->count('*')])
                ->group('Books.id');

            $sm_count_subquery = TableRegistry::get('SmallChapters')
                ->find('all', ['contain' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]);
            $sm_count_subquery
                ->select(['Books.id','count' => $sm_count_subquery->func()->count('*')])
                ->group('Books.id');

            $studies = TableRegistry::get('Books')
                ->find('all', [
                    'join' => [
                        'StudiesCount' => [
                            'table' => $studies_subquery,
                            'type' => 'LEFT',
                            'conditions' => 'books.id = StudiesCount.Books__id'
                        ],
                        'SmallCount' => [
                            'table' => $sm_count_subquery,
                            'type' => 'LEFT',
                            'conditions' => 'books.id = SmallCount.Books__id'
                        ]
                    ]
                ])
                ->select([
                    'Books.id',
                    'Books.title',
                    'StudiesCount.count',
                    'SmallCount.count',
                ])
                ->where('Books.status_id in (2)');

            $cnt = 0;
            foreach ($studies as $study) {
                if($cnt < 30) {
                    $count_data[$cnt]['title'] = $study->title;
                    $count_data[$cnt]['date']['Y'] = $start_date->format('Y');
                    $count_data[$cnt]['date']['m'] = $start_date->format('m');
                    $count_data[$cnt]['date']['d'] = $start_date->format('d');
                    $count_data[$cnt]['count'] = $study->StudiesCount['count'];
                    $count_data[$cnt]['schapter_total'] = $study->SmallCount['count'];
                }
                $cnt++;
            }
            $data[] = $count_data;

            $start_date->modify('+1 days');
        }
        $json_data = json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

        $this->set(compact('json_data'));

    }

    private function _getfirstBook(){
        $Books = TableRegistry::get('Books');
        return $Books
            ->find()
            ->select(['id'])
            ->order(['display_order' => 'ASC'])
            ->first()
            ->id;
    }

    private function _getLaps($searchBooks) {
        return TableRegistry::get('Books')
            ->find()
            ->select(['Laps'])
            ->where(["Books.id = {$searchBooks}"])
            ->first()
            ->Laps;
    }

}
