<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 */
class BooksController extends AppController
{

    public $components = ['BooksMethods'];

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
            $this->BooksMethods->BooksDisplayorderChange($this->request->data['display_order']);

            $this->request->data["select_flg"] = 1;
            $book = $this->Books->patchEntity($book, $this->request->data);
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }

        // 表示順番のプルダウン
        $select_display_order = $this->BooksMethods->BooksDisplyaOrderPulldownCreate();
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

        $select_display_order = $this->BooksMethods->BooksDisplyaOrderPulldownCreate();
        $select_status = $this->BooksMethods->StatusPulldownCreate();

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

        $this->BooksMethods->BooksDisplayorderChange($book->display_order);

        if ($this->Books->delete($book)) {
            $this->Flash->success(__('The book has been deleted.'));
        } else {
            $this->Flash->error(__('The book could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * json読み込みページ
     */
    public function json(){
        $book = $this->Books->newEntity();

        $error = '';
        if ($this->request->is('post')) {
            // json読み込み処理
            $fileName = $this->request->data['json']['tmp_name'];
            $json = file_get_contents($fileName);
            $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
            $json = json_decode($json,true);
            if(!$json) $error = 'アップロード失敗';

            $Big_Chapters = TableRegistry::get('Big_Chapters');
            $Middle_Chapters = TableRegistry::get('Middle_Chapters');
            $Small_Chapters = TableRegistry::get('Small_Chapters');

            $big_chapter_query = $Big_Chapters->query();
            $middle_chapter_query = $Middle_Chapters->query();
            $small_chapter_query = $Small_Chapters->query();

            // トランザクション開始
            $this->Books->connection()->begin();
            $Big_Chapters->connection()->begin();
            $Middle_Chapters->connection()->begin();
            $Small_Chapters->connection()->begin();

            foreach ($json as $key1 => $value1){
                //技術書登録処理
                $data_books = [
                    'title' => $key1,
                    'url' => '',
                    'display_order' => '1',
                    'status_id' => '2',
                    'laps' => '1',
                    'select_flg' => '1'
                ];
                $book = $this->Books->patchEntity($book, $data_books);
                $this->_displayorderNew( 1 );
                if(!$this->Books->save($book)){
                    $this->_rollback($book);
                    break;
                }

                //大分類登録処理
                $target_books = $this->Books->find()
                    ->order(['id'=>'DESC'])
                    ->first()->id;
                $big_chapter_cnt = 1;
                foreach ($value1 as $key2 => $value2){
                    $res = $big_chapter_query->insert(['book_id', 'title', 'display_order', 'select_flg', 'created', 'modified'])
                        ->values([
                            'book_id'=>$target_books,
                            'title'=>$key2,
                            'display_order'=>$big_chapter_cnt,
                            'select_flg'=>'1',
                            'created'=>Time::now(),
                            'modified'=>Time::now()
                        ])
                        ->execute();
                    $big_chapter_query->parts_values_reset();

                    //中分類登録処理
                    $target_big_chapters = $Big_Chapters->find()
                        ->order(['id'=>'DESC'])
                        ->first()->id;
                    $middle_chapter_cnt = 1;
                    foreach ($value2 as $key3 => $value3){
                        $res = $middle_chapter_query->insert(['big_chapter_id', 'title', 'display_order', 'select_flg', 'created', 'modified'])
                            ->values([
                                'big_chapter_id'=>$target_big_chapters,
                                'title'=>$key3,
                                'display_order'=>$middle_chapter_cnt,
                                'select_flg'=>'1',
                                'created'=>Time::now(),
                                'modified'=>Time::now()
                            ])
                            ->execute();
                        $middle_chapter_query->parts_values_reset();

                        //小分類登録処理
                        $target_middle_chapters = $Middle_Chapters->find()
                            ->order(['id'=>'DESC'])
                            ->first()->id;
                        $small_chapter_cnt = 1;
                        foreach ($value3 as $value4){
                            $res = $small_chapter_query->insert(['middle_chapter_id', 'title', 'display_order', 'select_flg', 'created', 'modified'])
                                ->values([
                                    'middle_chapter_id'=>$target_middle_chapters,
                                    'title'=>$value4,
                                    'display_order'=>$small_chapter_cnt,
                                    'select_flg'=>'1',
                                    'created'=>Time::now(),
                                    'modified'=>Time::now()
                                ])
                                ->execute();
                            $small_chapter_query->parts_values_reset();

                            $small_chapter_cnt++;
                        }

                        $middle_chapter_cnt++;
                    }

                    $big_chapter_cnt++;
                }

                // コミット
                $this->Books->connection()->commit();
                $Big_Chapters->connection()->commit();
                $Middle_Chapters->connection()->commit();
                $Small_Chapters->connection()->commit();
                $this->Flash->success('The user has been saved.');
            }

            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact(
            'book',
            'error'
        ));
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

        $st_count_subquery = TableRegistry::get('Studies')
            ->find('all', ['contain' => ['SmallChapters' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]]);
        $st_count_subquery
            ->select(['Books.id','count' => $st_count_subquery->func()->count('*')])
            ->group('Books.id');

        $sm_count_subquery = TableRegistry::get('SmallChapters')
            ->find('all', ['contain' => ['MiddleChapters' => ['BigChapters' => ['Books']]]]);
        $sm_count_subquery
            ->select(['Books.id','count' => $sm_count_subquery->func()->count('*')])
            ->group('Books.id');

        // books一覧表示
        $limit = '100';
        $books = $this->Books
            ->find('all',[
                'limit' => $limit,
                'join' => [
                    'StudiesCount' => [
                        'table' => $st_count_subquery,
                        'type' => 'LEFT',
                        'conditions' => 'books.id = StudiesCount.Books__id'
                    ],
                    'SmallCount' => [
                        'table' => $sm_count_subquery,
                        'type' => 'LEFT',
                        'conditions' => 'books.id = SmallCount.Books__id'
                    ],
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
                'StudiesCount.count',
                'SmallCount.count'
            ])
            ->order(['books.display_order' => 'ASC']);

        $this->paginate = ['limit' => $limit];
        $this->paginate($this->Books);

        $this->set(compact('books'));

    }

    /**
     * @param $src_display_order 古い順番
     * @param $display_order 新しい順番
     */
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

    public function _rollback(){
        // バリデーションエラー表示
        $this->Flash->error('The user could not be saved. Please, try again.');
        // ロールバック
        $this->Books->connection()->rollback();
        TableRegistry::get('Big_Chapters')->connection()->rollback();
        TableRegistry::get('Middle_Chapters')->connection()->rollback();
        TableRegistry::get('Small_Chapters')->connection()->rollback();
    }

}
