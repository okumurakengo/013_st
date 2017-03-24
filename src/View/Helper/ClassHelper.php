<?php
namespace App\View\Helper;

use Cake\View\Helper;

class ClassHelper extends Helper
{
    public function books_tr_class($status_id)
    {
        $sp = ' ';
        if($status_id === 5){
            return $sp . 'books_done';
        } elseif($status_id === 3) {
            return $sp . 'books_hold';
        }
        return;
    }

    public function books_td_class($status_id)
    {
        return $status_id === 1 ? 'books_new' : '';
    }
}