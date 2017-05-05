<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class CommonComponent extends Component
{
    /**
     * プルダウン作成処理
     */
    //ステータスのプルダウン
    final public function StatusPulldownCreate()
    {
        $Statuses = TableRegistry::get('Statuses');
        $arr_status = $Statuses
            ->find()
            ->select(['id','title'])
            ->order(['display_order' => 'ASC']);
        foreach ($arr_status as $value) {
            $select_status[$value->id] = $value->title;
        }
        return $select_status;
    }

    //表示順番のプルダウン
    private $select_display_order;

    final protected function DisplyaOrderPulldownCreate($targetTable,$targetColumn)
    {
        $arrayTarget = TableRegistry::get($targetTable)
            ->find()
            ->select(['id',$targetColumn,'display_order'])
            ->order(['display_order' => 'asc']);
        $this->select_display_order[1] = "最初に表示する";
        foreach ($arrayTarget as $value) {
            if(isset($this->request->params['pass'][0])) {
                if ($value['id'] !== (int)$this->request->params['pass'][0]) {
                    $this->pulldownContents($value,$targetColumn);
                }
            }else{
                $this->pulldownContents($value,$targetColumn);
            }
        }
        return $this->select_display_order;
    }

    private function pulldownContents($value,$targetColumn)
    {
        $this->select_display_order[$value['display_order'] + 1] = '「' . $value['display_order'] . '. ' . $value[$targetColumn] . '」の次に表示する';
    }

    /**
     * 表示順変更処理
     */
    final protected function displayorderChange($display_order,$targetTable,$action)
    {
        $targetTable = TableRegistry::get($targetTable);
        $targetTableData = $targetTable
            ->find()
            ->select(['id','display_order'])
            ->where($this->NewDeleteWhere($display_order,$action))
            ->order(['display_order' => 'DESC']);
        foreach ($targetTableData as $value) {
            $update_date = $targetTable
                ->find('all')
                ->where(['id' => $value['id']])
                ->first();
            $update_date->display_order = $this->NewDeleteChange($value->display_order,$action);
            $targetTable->save($update_date);
        }
    }

    private function NewDeleteWhere($display_order,$status)
    {
        switch ($status){
            case 'add':
                return "display_order >= {$display_order}";
            case 'delete':
                return "display_order > {$display_order}";
        }
    }

    private function NewDeleteChange($display_order,$status)
    {
        switch ($status){
            case 'add':
                return $display_order + 1;
            case 'delete':
                return $display_order - 1;
        }
    }
}