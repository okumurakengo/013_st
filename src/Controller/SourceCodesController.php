<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SourceCodes Controller
 *
 * @property \App\Model\Table\SourceCodesTable $SourceCodes
 */
class SourceCodesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Projects']
        ];
        $sourceCodes = $this->paginate($this->SourceCodes);

        $this->set(compact('sourceCodes'));
        $this->set('_serialize', ['sourceCodes']);
    }

    /**
     * View method
     *
     * @param string|null $id Source Code id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sourceCode = $this->SourceCodes->get($id, [
            'contain' => ['Projects', 'SourceCodes', 'Analyses']
        ]);

        $this->set('sourceCode', $sourceCode);
        $this->set('_serialize', ['sourceCode']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sourceCode = $this->SourceCodes->newEntity();
        if ($this->request->is('post')) {
            $sourceCode = $this->SourceCodes->patchEntity($sourceCode, $this->request->data);
            if ($this->SourceCodes->save($sourceCode)) {
                $this->Flash->success(__('The source code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The source code could not be saved. Please, try again.'));
        }
        $projects = $this->SourceCodes->Projects->find('list', ['limit' => 200]);
        $this->set(compact('sourceCode', 'projects'));
        $this->set('_serialize', ['sourceCode']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Source Code id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sourceCode = $this->SourceCodes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sourceCode = $this->SourceCodes->patchEntity($sourceCode, $this->request->data);
            if ($this->SourceCodes->save($sourceCode)) {
                $this->Flash->success(__('The source code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The source code could not be saved. Please, try again.'));
        }
        $projects = $this->SourceCodes->Projects->find('list', ['limit' => 200]);
        $this->set(compact('sourceCode', 'projects'));
        $this->set('_serialize', ['sourceCode']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Source Code id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sourceCode = $this->SourceCodes->get($id);
        if ($this->SourceCodes->delete($sourceCode)) {
            $this->Flash->success(__('The source code has been deleted.'));
        } else {
            $this->Flash->error(__('The source code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
