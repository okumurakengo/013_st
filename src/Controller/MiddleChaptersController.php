<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * MiddleChapters Controller
 *
 * @property \App\Model\Table\MiddleChaptersTable $MiddleChapters
 */
class MiddleChaptersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'sortWhitelist' => [
                'Books.id',
                'Books.display_order',
                'BigChapters.display_order',
                'display_order'
            ],
            'order' => [
                'Books.display_order' => 'asc',
                'BigChapters.display_order' => 'asc',
                'display_order' => 'asc'
            ],
            'contain' => [
                'BigChapters' => [
                    'Books'
                ]
            ],
            'limit' => 100
        ];
        $Books = TableRegistry::get('Books');
        $BookId = $Books
                    ->find()
                    ->select(['id'])
                    ->order(['display_order' => 'ASC'])
                    ->first()
                    ->id;
        $searchBooks = [];
        if ($this->request->is('post')) {
            $BookId = $this->request->data['books'];
            $searchBooks = [$this->request->data['books']];
        }
        $middleChapters = $this->paginate(
            $this->MiddleChapters
                ->find()
                ->where(["books.id = {$BookId}"])
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

        $this->set(compact('middleChapters'));
        $this->set('_serialize', ['middleChapters']);
    }

    /**
     * View method
     *
     * @param string|null $id Middle Chapter id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $middleChapter = $this->MiddleChapters->get($id, [
            'contain' => ['BigChapters', 'SmallChapters']
        ]);

        $this->set('middleChapter', $middleChapter);
        $this->set('_serialize', ['middleChapter']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $middleChapter = $this->MiddleChapters->newEntity();
        if ($this->request->is('post') && empty($this->request->data['search'])) {
            $middleChapter = $this->MiddleChapters->patchEntity($middleChapter, $this->request->data);
            if ($this->MiddleChapters->save($middleChapter)) {
                $this->Flash->success(__('The middle chapter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The middle chapter could not be saved. Please, try again.'));
        }
        // 検索フォーム
        // 技術書名
        $Books = TableRegistry::get('Books');
        $searchBooks = $Books
            ->find()
            ->select(['id'])
            ->order(['display_order' => 'ASC'])
            ->first()
            ->id;
        if (isset($this->request->data['search'])) {
            $searchBooks = $this->request->data['books'];
        }
        $arrBooks = TableRegistry::get('Books')
            ->find()
            ->select(['id', 'display_order', 'title'])
            ->order(['books.display_order' => 'ASC']);
        foreach ($arrBooks as $value) {
            $selectBooks[$value['id']] = $value['display_order'] . ". " . $value['title'];
        }
        $arrBigChapters = TableRegistry::get('BigChapters')
            ->find()
            ->select(['id', 'display_order', 'title'])
            ->innerJoinWith('Books')
            ->where("books.id = $searchBooks")
            ->order(["BigChapters.display_order" => 'ASC']);
        foreach ($arrBigChapters as $value) {
            $selectBigChapters[$value['id']] = $value['display_order'] . ". " . $value['title'];
        }
        $this->set(compact('selectBooks','searchBooks','selectBigChapters'));

        $bigChapters = $this->MiddleChapters->BigChapters
            ->find('list')
            ->select(['id', 'title', 'display_order'])
            ->innerJoinWith('Books')
            ->where("books.display_order = $searchBooks");

        // 大分類の検索
        $mChapter_cnt = $this->MiddleChapters
            ->find('all', ['contain' => ['BigChapters' =>['Books']]])
            ->where("Books.id = $searchBooks")
            ->count();
        if ($mChapter_cnt !== 0) {
            // middle_chaptersにデータがある場合は、一番最後のデータを持ってくる
            $searchBigChapters = $this->MiddleChapters
                ->find('all', ['contain' => ['BigChapters' =>['Books']]])
                ->select(['BigChapters.id'])
                ->where("Books.id = $searchBooks")
                ->order(['BigChapters.display_order' => 'DESC'])
                ->order(['MiddleChapters.display_order' => 'DESC'])
                ->first()->BigChapters->id;
        } else {
            // middle_chaptersにデータがない場合は最初の大分類を持ってくる
            $searchBigChapters = TableRegistry::get('BigChapters')
                ->find('all', ['contain' => ['Books']])
                ->select(['id'])
                ->where("Books.id = $searchBooks")
                ->order(['BigChapters.display_order' => 'ASC'])
                ->first()->id;
        }
        if ($this->request->is('post')) {
            $searchBigChapters = $this->request->data['big_chapter_id'];
        }
        // 表示順番のプルダウン
        $query = $this->MiddleChapters
            ->find('all', ['contain' => ['BigChapters' => ['Books']]])
            ->select(['id','title','display_order'])
            ->where("books.id = $searchBooks")
            ->where("BigChapters.id = $searchBigChapters")
            ->order(['MiddleChapters.display_order' => 'ASC']);
        $select_display_order[1] = "最初に表示する";
        foreach ($query as $value) {
            $select_display_order[$value['display_order'] + 1] = '「' . $value['display_order'] . '. ' . $value['title'] . '」の次に表示する';
        }
        $this->set(compact(
            'select_display_order',
            'searchBigChapters',
            'lastBigChapters'
        ));

        $this->set(compact('middleChapter', 'bigChapters'));
        $this->set('_serialize', ['middleChapter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Middle Chapter id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $middleChapter = $this->MiddleChapters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $middleChapter = $this->MiddleChapters->patchEntity($middleChapter, $this->request->data);
            if ($this->MiddleChapters->save($middleChapter)) {
                $this->Flash->success(__('The middle chapter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The middle chapter could not be saved. Please, try again.'));
        }
        $bigChapters = $this->MiddleChapters->BigChapters->find('list', ['limit' => 200]);
        $this->set(compact('middleChapter', 'bigChapters'));
        $this->set('_serialize', ['middleChapter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Middle Chapter id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $middleChapter = $this->MiddleChapters->get($id);
        if ($this->MiddleChapters->delete($middleChapter)) {
            $this->Flash->success(__('The middle chapter has been deleted.'));
        } else {
            $this->Flash->error(__('The middle chapter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
