<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * BigChapters Controller
 *
 * @property \App\Model\Table\BigChaptersTable $BigChapters
 */
class BigChaptersController extends AppController
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
                'books.display_order',
                'display_order'
            ],
            'order' => [
                'books.display_order' => 'asc',
                'display_order' => 'asc'
            ],
            'contain' => ['Books'],
        ];
        $Books = TableRegistry::get('Books');
        $BookId = $Books
            ->find()
            ->select(['id'])
            ->order(['display_order' => 'ASC'])
            ->first()
            ->id;
        if ($this->request->is('post')) {
            $BookId = $this->request->data['books'];
        }
        $bigChapters = $this->paginate(
            $this->BigChapters
                ->find('all', ['contain' => ['Books']])
                ->where(["books.id = $BookId"])
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
        $searchBooks = [];
        if ($this->request->is('post')) {
            $searchBooks = [$this->request->data['books']];
        }
        $this->set(compact('selectBooks','searchBooks'));

        $this->set(compact('bigChapters'));
        $this->set('_serialize', ['bigChapters']);
    }

    /**
     * View method
     *
     * @param string|null $id Big Chapter id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bigChapter = $this->BigChapters->get($id, [
            'contain' => ['Books', 'MiddleChapters']
        ]);

        $this->set('bigChapter', $bigChapter);
        $this->set('_serialize', ['bigChapter']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bigChapter = $this->BigChapters->newEntity();
        if ($this->request->is('post')) {
            $bigChapter = $this->BigChapters->patchEntity($bigChapter, $this->request->data);
            if ($this->BigChapters->save($bigChapter)) {
                $this->Flash->success(__('The big chapter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The big chapter could not be saved. Please, try again.'));
        }
        $books = $this->BigChapters->Books
            ->find('list', ['limit' => 200])
            ->order(['display_order' => 'ASC']);
        $this->set(compact('bigChapter', 'books'));
        $this->set('_serialize', ['bigChapter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Big Chapter id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bigChapter = $this->BigChapters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bigChapter = $this->BigChapters->patchEntity($bigChapter, $this->request->data);
            if ($this->BigChapters->save($bigChapter)) {
                $this->Flash->success(__('The big chapter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The big chapter could not be saved. Please, try again.'));
        }
        $books = $this->BigChapters->Books->find('list', ['limit' => 200]);
        $this->set(compact('bigChapter', 'books'));
        $this->set('_serialize', ['bigChapter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Big Chapter id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bigChapter = $this->BigChapters->get($id);
        if ($this->BigChapters->delete($bigChapter)) {
            $this->Flash->success(__('The big chapter has been deleted.'));
        } else {
            $this->Flash->error(__('The big chapter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
