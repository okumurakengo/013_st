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

    public function book_count($count)
    {
        return $count ? $count : '0';
    }

    public function percent($StudiesCount,$SmallCount)
    {
        if($this->book_count($SmallCount)) {
            return sprintf('%.3f', h($this->book_count($StudiesCount) / h($this->book_count($SmallCount)))) * 100;
        }
        return 0;
    }
}