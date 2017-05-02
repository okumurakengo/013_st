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
        $cat = $this->request->data['cat'];
        $past = $this->request->data['past'];

        $start_date_add = new Time($this->request->data['start_date']);
        $start_date_add->modify('+1 days');

        $compare_start_date = [];
        $compare_start_date_add = [];
        $day_timestamp =24 * 60 * 60;
        for($i=0;$i<$past;$i++) {
            $compare_start_date[] = Time::createFromTimestamp($start_date->toUnixString() - (($date_diff * ($i+1)) * $day_timestamp)- $day_timestamp * ($i+1));
            $compare_start_date_add[] = Time::createFromTimestamp($start_date_add->toUnixString() - ((($date_diff * ($i+1))) * $day_timestamp) - $day_timestamp * ($i+1));
        }

        if($cat === 'studies') {
            $json_data = $this->_drawgraph_studies($start_date,$date_diff);
        }else if ($cat === 'day'){
            $json_data = $this->_drawgraph_day($start_date,$start_date_add,$date_diff,$compare_start_date,$compare_start_date_add);
        }

        $this->set(compact('json_data'));
    }

    private function _drawgraph_studies($start_date,$date_diff){
        $start_date->modify('+1 days');
        for ($i = 0; $i <= $date_diff; $i++) {
            $studies_subquery = $this->Studies
                ->find('all', ['contain' => ['SmallChapters' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]])
                ->where("Studies.created <= '{$start_date->format('Y-m-d')}'");
            $studies_subquery
                ->select(['Books.id', 'count' => $studies_subquery->func()->count('*')])
                ->group('Books.id');

            $sm_count_subquery = TableRegistry::get('SmallChapters')
                ->find('all', ['contain' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]);
            $sm_count_subquery
                ->select(['Books.id', 'count' => $sm_count_subquery->func()->count('*')])
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
                $count_data[$cnt]['title'] = $study->title;
                $count_data[$cnt]['date']['Y'] = $start_date->format('Y');
                $count_data[$cnt]['date']['m'] = $start_date->format('m');
                $count_data[$cnt]['date']['d'] = $start_date->format('d');
                $count_data[$cnt]['count'] = $study->StudiesCount['count'];
                $count_data[$cnt]['schapter_total'] = $study->SmallCount['count'];
                $cnt++;
            }
            $data[] = $count_data;

            $start_date->modify('+1 days');
        }
        return $this->_json($data);
    }

    private function _drawgraph_day($start_date,$start_date_add,$date_diff,$compare_start_date,$compare_start_date_add){
        $tmp_start_date = $start_date->format('n/j');
        for($i=0;$i<count($compare_start_date);$i++) {
            $tmp_compare_start_date[$i] = $compare_start_date[$i]->format('n/j');
        }
        for($i=0;$i<count($compare_start_date)+1;$i++) {
            $cnt[] = 0;
        }
        for ($i = 0; $i <= $date_diff; $i++) {
            $query = $this->Studies
                ->find()
                ->where([
                    'Studies.created BETWEEN :start AND :end'
                ])
                ->bind(':start', $start_date->format('Y-m-d'), 'date')
                ->bind(':end', $start_date_add->format('Y-m-d'), 'date');
            $query
                ->select(['count' => $query->func()->count('*')]);

            foreach ($query as $val) {
                $day_data[] = [$start_date->format('Y-m-d'),$val->count];
            }

            if($i<$date_diff) {
                $start_date->modify('+1 days');
                $start_date_add->modify('+1 days');
            }

            for ($j=0;$j<count($compare_start_date);$j++){
                $compare_query = $this->Studies
                    ->find()
                    ->where([
                        'Studies.created BETWEEN :start AND :end'
                    ])
                    ->bind(':start', $compare_start_date[$j]->format('Y-m-d'), 'date')
                    ->bind(':end', $compare_start_date_add[$j]->format('Y-m-d'), 'date');
                $compare_query
                    ->select(['count' => $compare_query->func()->count('*')]);

                foreach ($compare_query as $compare_val) {
                    array_splice($day_data[$cnt[$j]],1,0,$compare_val->count);
                    $cnt[$j]++;
                }

                if($i<$date_diff) {
                    $compare_start_date[$j]->modify('+1 days');
                    $compare_start_date_add[$j]->modify('+1 days');
                }
            }
        }

        array_unshift($day_data,['日時',$tmp_start_date.'〜'.$start_date->format('n/j')]);
        for($i=0;$i<count($compare_start_date);$i++) {
            array_splice($day_data[0],1,0,$tmp_compare_start_date[$i].'〜'.$compare_start_date[$i]->format('n/j'));
        }

        return $this->_json($day_data);
    }

    private function _json($data){
        return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
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
