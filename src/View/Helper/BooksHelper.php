<?php
namespace App\View\Helper;

use Cake\View\Helper;

class BooksHelper extends CommonHelper
{
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