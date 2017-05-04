<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Analyses Controller
 *
 * @property \App\Model\Table\AnalysesTable $Analyses
 */
class AnalysesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'SourceCodes', 'Statuses']
        ];
        $analyses = $this->paginate($this->Analyses);

        $this->set(compact('analyses'));
        $this->set('_serialize', ['analyses']);
    }

    /**
     * View method
     *
     * @param string|null $id Analysis id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $analysis = $this->Analyses->get($id, [
            'contain' => ['Users', 'SourceCodes', 'Statuses']
        ]);

        $this->set('analysis', $analysis);
        $this->set('_serialize', ['analysis']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $analysis = $this->Analyses->newEntity();
        if ($this->request->is('post')) {
            $analysis = $this->Analyses->patchEntity($analysis, $this->request->data);
            if ($this->Analyses->save($analysis)) {
                $this->Flash->success(__('The analysis has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The analysis could not be saved. Please, try again.'));
        }
        $users = $this->Analyses->Users->find('list', ['limit' => 200]);
        $sourceCodes = $this->Analyses->SourceCodes->find('list', ['limit' => 200]);
        $statuses = $this->Analyses->Statuses->find('list', ['limit' => 200]);
        $this->set(compact('analysis', 'users', 'sourceCodes', 'statuses'));
        $this->set('_serialize', ['analysis']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Analysis id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $analysis = $this->Analyses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $analysis = $this->Analyses->patchEntity($analysis, $this->request->data);
            if ($this->Analyses->save($analysis)) {
                $this->Flash->success(__('The analysis has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The analysis could not be saved. Please, try again.'));
        }
        $users = $this->Analyses->Users->find('list', ['limit' => 200]);
        $sourceCodes = $this->Analyses->SourceCodes->find('list', ['limit' => 200]);
        $statuses = $this->Analyses->Statuses->find('list', ['limit' => 200]);
        $this->set(compact('analysis', 'users', 'sourceCodes', 'statuses'));
        $this->set('_serialize', ['analysis']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Analysis id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $analysis = $this->Analyses->get($id);
        if ($this->Analyses->delete($analysis)) {
            $this->Flash->success(__('The analysis has been deleted.'));
        } else {
            $this->Flash->error(__('The analysis could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
