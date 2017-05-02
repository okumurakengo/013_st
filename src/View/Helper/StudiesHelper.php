<?php
/**
 * Created by PhpStorm.
 * User: tanosindemorauningen
 * Date: 2017/04/30
 * Time: 19:40
 */

namespace App\View\Helper;
use Cake\I18n\Time;

use Cake\View\Helper;

class StudiesHelper Extends Helper
{
    public function start_date($cat){
        switch ($cat){
            case 'studies':
                $start_date = Time::createFromTimestamp($_SERVER['REQUEST_TIME'] - (90 * 24 * 60 * 60));
                break;
            case 'day':
                $start_date = Time::createFromTimestamp($_SERVER['REQUEST_TIME'] - (6 * 24 * 60 * 60));
                break;
        }
        return $start_date->i18nFormat('yyyy/MM/dd');
    }

    public function end_date(){
        $end_date = Time::now();
        return $end_date->i18nFormat('yyyy/MM/dd');
    }
}