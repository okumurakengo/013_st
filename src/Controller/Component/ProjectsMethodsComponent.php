<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class ProjectsMethodsComponent extends CommonComponent
{
    private $targetTable = 'Projects';

    public function ProjectsDisplayorderChange($display_order)
    {
        $this->displayorderChange($display_order, $this->targetTable,$this->request->params['action']);
    }

    public function ProjectsDisplyaOrderPulldownCreate()
    {
        return $this->DisplyaOrderPulldownCreate($this->targetTable,'title');
    }
}