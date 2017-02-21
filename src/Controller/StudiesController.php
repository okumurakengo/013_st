<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

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
        $Books = TableRegistry::get('Books');
        $searchBooks = $Books
            ->find()
            ->select(['id'])
            ->order(['display_order' => 'ASC'])
            ->first()
            ->id;
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
        $Books = TableRegistry::get('Books');
        $searchBooks = $Books
            ->find()
            ->select(['id'])
            ->order(['display_order' => 'ASC'])
            ->first()->id;
        $BigChapters = TableRegistry::get('BigChapters');
        if ($this->request->is('post')) {
            $searchBooks = $this->request->data['books'];
        }
        $bChapter_cnt = TableRegistry::get('BigChapters')
            ->find('all', ['contain' =>['Books']])
            ->where("Books.id = $searchBooks")
            ->count();
        if ($bChapter_cnt !== 0) {
            $searchBigChapters = $BigChapters
                ->find('all', ['contain' => ['Books']])
                ->select(['BigChapters.id'])
                ->where("books.id = $searchBooks")
                ->order(['BigChapters.display_order' => 'ASC'])
                ->first()->id;
        }
        if (isset($this->request->data['big_chapters_flg']) && $this->request->data['big_chapters_flg'] === '1') {
            $searchBigChapters = $this->request->data['big_chapters'];
        }

        // 登録処理
        $study = $this->Studies->newEntity();
        if ($this->request->is('post') && empty($this->request->data['search'])) {
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
        }
        $this->set(compact(
            'selectBooks',
            'searchBooks',
            'selectBigChapters',
            'searchBigChapters',
            'selectSmallChapters'
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
}
