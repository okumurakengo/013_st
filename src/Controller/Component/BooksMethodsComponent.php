<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class BooksMethodsComponent extends CommonComponent
{
    private $targetTable = 'Books';

    public function BooksDisplayorderChange($display_order)
    {
        $this->displayorderChange($display_order, $this->targetTable,$this->request->params['action']);
    }

    public function BooksDisplyaOrderPulldownCreate()
    {
        return $this->DisplyaOrderPulldownCreate($this->targetTable,'title');
    }
}