<?php
namespace App\View\Helper;

use Cake\View\Helper;

class BooksHelper extends Helper
{
    public function book_or_site($url,$title)
    {
        if($url){
            return "<a href=\"{$url}\" target=\"_blank\">{$title}</a>";
        }else{
            return $title;
        }
    }
}