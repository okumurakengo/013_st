<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * SmallChapters Controller
 *
 * @property \App\Model\Table\SmallChaptersTable $SmallChapters
 */
class SmallChaptersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'MiddleChapters' => [
                    'BigChapters' => [
                        'Books'
                    ]
                ]
            ],
            'limit' => 300,
            'maxLimit' => 300,
        ];

        // 最初のBookIDを取得
        $searchBooks = [];
        $Books = TableRegistry::get('Books');
        $BookId = $Books
            ->find()
            ->select(['id'])
            ->order(['display_order' => 'ASC'])
            ->first()
            ->id;
        if ($this->request->is('post')) {
            $BookId = $this->request->data['books'];
            $searchBooks = [$this->request->data['books']];
        }
        $smallChapters = $this->paginate(
            $this->SmallChapters
                ->find()
                ->where(["books.id = {$BookId}"])
                ->order(['BigChapters.display_order' => 'asc',
                    'MiddleChapters.display_order' => 'asc',
                    'SmallChapters.display_order' => 'asc'
                ])
        );

        // 検索フォーム
        // 技術書名
        $arrBooks = TableRegistry::get('Books')
            ->find()
            ->select(['id', 'display_order', 'title'])
            ->order(['books.display_order' => 'ASC']);
        foreach ($arrBooks as $value) {
            $selectBooks[$value['id']] = $value['display_order'] . ". " . $value['title'];
        }
        $this->set(compact('selectBooks','searchBooks'));

        $this->set(compact('smallChapters'));
        $this->set('_serialize', ['smallChapters']);
    }

    /**
     * View method
     *
     * @param string|null $id Small Chapter id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $smallChapter = $this->SmallChapters->get($id, [
            'contain' => ['MiddleChapters', 'Studies']
        ]);

        $this->set('smallChapter', $smallChapter);
        $this->set('_serialize', ['smallChapter']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // 検索フォーム
        // 技術書名
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

        // 中分類の検索
        $sChapter_cnt = $this->SmallChapters
            ->find('all', ['contain' => ['MiddleChapters' => ['BigChapters' =>['Books']]]])
            ->where("Books.id = $searchBooks")
            ->count();
        if ($sChapter_cnt !== 0) {
            // middle_chaptersにデータがある場合は、一番最後のデータを持ってくる
            $searchMiddleChapters = $this->SmallChapters
                ->find('all', ['contain' => ['MiddleChapters' => ['BigChapters' =>['Books']]]])
                ->select(['MiddleChapters.id'])
                ->where("Books.id = $searchBooks")
                ->order(['BigChapters.display_order' => 'DESC'])
                ->order(['MiddleChapters.display_order' => 'DESC'])
                ->order(['SmallChapters.display_order' => 'DESC'])
                ->first()->MiddleChapters->id;
        } else {
            // middle_chaptersにデータがない場合は最初の大分類を持ってくる
            $searchMiddleChapters = TableRegistry::get('MiddleChapters')
                ->find('all', ['contain' => ['BigChapters' => ['Books']]])
                ->select(['id'])
                ->where("Books.id = $searchBooks")
                ->order(['BigChapters.display_order' => 'ASC'])
                ->order(['MiddleChapters.display_order' => 'ASC'])
                ->first()->id;
        }
        if ($this->request->is('post')) {
            $searchMiddleChapters = $this->request->data['middle_chapter_id'];
        }

        // 登録処理
        $smallChapter = $this->SmallChapters->newEntity();
        if ($this->request->is('post') && empty($this->request->data['search'])) {

            // 表示順変更処理
            $SmallChapters_data_all = TableRegistry::get('SmallChapters');

            $SmallChapters_display_order = $this->request->data['display_order'];
            $SmallChapters_data = $SmallChapters_data_all
                ->find('all', ['contain' => ['MiddleChapters' => ['BigChapters' => ['Books']]]])
                ->select(['SmallChapters.id','SmallChapters.display_order'])
                ->where("Books.id = $searchBooks")
                ->where("MiddleChapters.id = $searchMiddleChapters")
                ->where("SmallChapters.display_order >= $SmallChapters_display_order");
            foreach ($SmallChapters_data as $value) {
                $update_date = $SmallChapters_data_all
                    ->find('all')
                    ->where(['id' => $value['id']])
                    ->where("middle_chapter_id = $searchMiddleChapters")
                    ->first();
                $update_date->display_order = $value->display_order + 1;
                $SmallChapters_data_all->save($update_date);
            }

            $smallChapter = $this->SmallChapters->patchEntity($smallChapter, $this->request->data);
            if ($this->SmallChapters->save($smallChapter)) {
                $this->Flash->success(__('The small chapter has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The small chapter could not be saved. Please, try again.'));
        }

        $arrBooks = TableRegistry::get('Books')
            ->find()
            ->select(['id', 'display_order', 'title'])
            ->order(['books.display_order' => 'ASC']);
        foreach ($arrBooks as $value) {
            $selectBooks[$value['id']] = $value['display_order'] . ". " . $value['title'];
        }
        $arrMiddleChapters = TableRegistry::get('MiddleChapters')
            ->find('all', ['contain' => ['BigChapters' => ['Books']]])
            ->select(['id', 'display_order', 'title', 'BigChapters.id', 'BigChapters.title', 'BigChapters.display_order'])
            ->where("books.id = $searchBooks")
            ->order(['BigChapters.display_order' => 'ASC'])
            ->order(['MiddleChapters.display_order' => 'ASC']);
        foreach ($arrMiddleChapters as $value) {
            $selectMiddleChapters[$value['big_chapter']['display_order'] . '. ' . $value['big_chapter']['title']][$value['id']] = $value['display_order'] . ". " . $value['title'];
            $jsonMiddleChapters[] = $value['id'];
        }
        $jsonMiddleChapters = json_encode($jsonMiddleChapters, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $this->set(compact(
            'selectBooks',
            'searchBooks',
            'selectMiddleChapters',
            'searchMiddleChapters',
            'jsonMiddleChapters'
        ));

        $bigChapters = $this->SmallChapters->MiddleChapters->BigChapters
            ->find('list')
            ->select(['id', 'title', 'display_order'])
            ->innerJoinWith('Books')
            ->where("books.id = $searchBooks");
        $middleChapters = $this->SmallChapters->MiddleChapters->find('list', ['limit' => 200]);

        $this->set(compact('smallChapter', 'middleChapters', 'bigChapters'));

        // 表示順番のプルダウン
        $query = $this->SmallChapters
            ->find('all', ['contain' => ['MiddleChapters' => ['BigChapters' => ['Books']]]])
            ->select(['id','middle_chapter_id','title','display_order'])
            ->where("books.id = $searchBooks")
            ->where("MiddleChapters.id = $searchMiddleChapters")
            ->order(['SmallChapters.display_order' => 'ASC']);
        $select_display_order[1] = "最初に表示する";
        foreach ($query as $value) {
            $select_display_order[$value['display_order'] + 1] = '「' . $value['display_order'] . '. ' . $value['title'] . '」の次に表示する';
        }
        $this->set(compact('select_display_order'));

        $this->set('_serialize', ['smallChapter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Small Chapter id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $smallChapter = $this->SmallChapters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $smallChapter = $this->SmallChapters->patchEntity($smallChapter, $this->request->data);
            if ($this->SmallChapters->save($smallChapter)) {
                $this->Flash->success(__('The small chapter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The small chapter could not be saved. Please, try again.'));
        }
        $middleChapters = $this->SmallChapters->MiddleChapters->find('list', ['limit' => 200]);
        $this->set(compact('smallChapter', 'middleChapters'));
        $this->set('_serialize', ['smallChapter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Small Chapter id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $smallChapter = $this->SmallChapters->get($id);
        if ($this->SmallChapters->delete($smallChapter)) {
            $this->Flash->success(__('The small chapter has been deleted.'));
        } else {
            $this->Flash->error(__('The small chapter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
