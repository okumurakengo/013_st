<?php
namespace App\View\Helper;

use Cake\View\Helper;

class CommonHelper extends Helper
{
    final public function site_judgment($url,$title)
    {
        if($url){
            return "<a href=\"{$url}\" target=\"_blank\">{$title}</a>";
        }else{
            return $title;
        }
    }

    public function date_format($date){
        return $date->format('Y年m月d日H:i');
    }

    public function status_tr_class($status_id)
    {
        switch ($status_id){
            case 3:
                return 'status_hold';
            case 5:
                return 'status_done';
            case 1:
            case 2:
            case 4:
                return 'status_normal';
        }
    }

    public function status_td_class($status_id)
    {
        switch ($status_id){
            case 1:
                return 'status_new';
            case 2:
            case 3:
            case 4:
            case 5:
                return 'status_normal';
        }
    }
}