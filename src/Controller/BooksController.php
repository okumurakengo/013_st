<?php
namespace App\Controller;

use App\Controller\AppController;

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
        $query = $this->Books
            ->find()
            ->select(['title','display_order'])
            ->order(['display_order' => 'ASC']);
        $select_display_order[1] = "最初に表示する";
        foreach ($query as $value) {
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

        // 表示順番のプルダウン
        $query = $this->Books
            ->find()
            ->select(['id','title','display_order'])
            ->order(['display_order' => 'ASC']);
        $i = 1;
        $select_display_order[$i] = "最初に表示する";
        foreach ($query as $value) {
            $select_display_order[$i++] = '「' . $value['display_order'] . '. ' . $value['title'] . '」の次に表示する';
        }
        $this->set(compact('select_display_order'));
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

        // books一覧表示
        $this->paginate = [
            'order' => [
                'display_order' => 'asc'
            ]
        ];
        $books = $this->paginate($this->Books);

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
