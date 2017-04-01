<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 */
class BooksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->_book_list();

        $this->set('_serialize', ['books']);
    }

    /**
     * View method
     *
     * @param string|null $id Book id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => ['BigChapters']
        ]);

        $this->set('book', $book);
        $this->set('_serialize', ['book']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $book = $this->Books->newEntity();
        if ($this->request->is('post')) {

            // 表示順変更処理
            $display_order = $this->request->data['display_order'];
            $Books_data = $this->Books
                ->find()
                ->select(['id','display_order'])
                ->where("display_order >= $display_order")
                ->order(['display_order' => 'DESC']);
            foreach ($Books_data as $value) {
                $update_date = $this->Books
                    ->find('all')
                    ->where(['id' => $value['id']])
                    ->first();
                $update_date->display_order = $value->display_order + 1;
                $this->Books->save($update_date);
            }

            $this->request->data["select_flg"] = 1;
            $book = $this->Books->patchEntity($book, $this->request->data);
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }

        // 表示順番のプルダウン
        $queryBooks = $this->Books;
        $arr_display_order = $queryBooks
            ->find()
            ->select(['title','display_order'])
            ->order(['display_order' => 'ASC']);
        $select_display_order[1] = "最初に表示する";
        foreach ($arr_display_order as $value) {
            $select_display_order[$value['display_order']+1]='「'.$value['display_order'].'. '.$value['title'].'」の次に表示する';
        }
        $this->set(compact('select_display_order'));
        $this->set(compact('book'));
        $this->set('_serialize', ['book']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Book id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data["select_flg"] = 1;

            // 表示順変更処理
            $display_order = $this->request->data['display_order'];
            $src_display_order = $book->display_order;
            $this->_displayorderEdit($src_display_order,$display_order);

            $book = $this->Books->patchEntity($book, $this->request->data);
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }

        $queryBooks = $this->Books;
        // 表示順番のプルダウン
        $arr_display_order = $queryBooks
            ->find()
            ->select(['id','title','display_order'])
            ->order(['display_order' => 'ASC']);
        $i = 1;
        $select_display_order[$i] = "最初に表示する";
        foreach ($arr_display_order as $value) {
            $select_display_order[$i++] = '「' . $value['display_order'] . '. ' . $value['title'] . '」の次に表示する';
        }
        $Statuses = TableRegistry::get('Statuses');
        $arr_status = $Statuses
            ->find()
            ->select(['id','title'])
            ->order(['display_order' => 'ASC']);
        foreach ($arr_status as $value) {
            $select_status[$value->id] = $value->title;
        }
        $this->set(compact(
            'select_display_order',
            'select_status'
        ));
        $this->set(compact('book'));
        $this->set('_serialize', ['book']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Book id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $book = $this->Books->get($id);
        if ($this->Books->delete($book)) {
            $this->Flash->success(__('The book has been deleted.'));
        } else {
            $this->Flash->error(__('The book could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // 表示順番変更
    public function ajax()
    {
        if ($this->request->is('post')) {
            $this->_displayorderEdit(
                $this->request->data['src_display_order'],
                $this->request->data['display_order']
            );
            $books = $this->Books->get($this->request->data['book_id']);
            $books->display_order = $this->request->data['display_order'];
            $this->Books->save($books);
            $this->_book_list();
        }
    }

    public function _book_list() {

        $subquery = TableRegistry::get('Studies')
            ->find('all', ['contain' => ['SmallChapters' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]]);
        $subquery
            ->select(['Books.id','count' => $subquery->func()->count('*')])
            ->group('Books.id');

        // books一覧表示
        $limit = '100';
        $books = $this->Books
            ->find('all',[
                'limit' => $limit,
                'join' => [
                    'StudiesCount' => [
                        'table' => $subquery,
                        'type' => 'LEFT',
                        'conditions' => 'books.id = StudiesCount.Books__id'
                    ]
                ],
                'contain' => ['Statuses'],
            ])
            ->select([
                'Books.id',
                'Books.title',
                'Books.url',
                'Books.display_order',
                'Books.status_id',
                'Books.laps',
                'Books.created',
                'Statuses.id',
                'Statuses.title',
                'StudiesCount.count'
            ])
            ->order(['books.display_order' => 'ASC']);

        $this->paginate = ['limit' => $limit];
        $this->paginate($this->Books);

        $this->set(compact('books'));

    }

    public function _displayorderEdit($src_display_order,$display_order) {

        // 表示順変更処理
        if ($src_display_order > $display_order) {
            // 変更する表示順が上がった場合
            $edit_target = ["display_order >= {$display_order}","display_order < {$src_display_order}"];
            $edit_display_order = 1;
        }else {
            // 変更する表示順が下がった場合
            $edit_target = ["display_order > {$src_display_order}","display_order <= {$display_order}"];
            $edit_display_order = -1;
        }
        $Books_data = $this->Books
            ->find()
            ->select(['id', 'display_order'])
            ->where($edit_target)
            ->order(['display_order' => 'DESC']);
        foreach ($Books_data as $value) {
            $update_date = $this->Books
                ->find('all')
                ->where(['id' => $value['id']])
                ->first();
            $update_date->display_order += $edit_display_order;
            $this->Books->save($update_date);
        }

    }

}
