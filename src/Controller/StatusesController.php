<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Statuses Controller
 *
 * @property \App\Model\Table\StatusesTable $Statuses
 */
class StatusesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $statuses = $this->paginate($this->Statuses);

        $this->set(compact('statuses'));
        $this->set('_serialize', ['statuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Status id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $status = $this->Statuses->get($id, [
            'contain' => ['Studies']
        ]);

        $this->set('status', $status);
        $this->set('_serialize', ['status']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $status = $this->Statuses->newEntity();
        if ($this->request->is('post')) {
            $status = $this->Statuses->patchEntity($status, $this->request->data);
            if ($this->Statuses->save($status)) {
                $this->Flash->success(__('The status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The status could not be saved. Please, try again.'));
        }
        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Status id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $status = $this->Statuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $status = $this->Statuses->patchEntity($status, $this->request->data);
            if ($this->Statuses->save($status)) {
                $this->Flash->success(__('The status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The status could not be saved. Please, try again.'));
        }
        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Status id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $status = $this->Statuses->get($id);
        if ($this->Statuses->delete($status)) {
            $this->Flash->success(__('The status has been deleted.'));
        } else {
            $this->Flash->error(__('The status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
