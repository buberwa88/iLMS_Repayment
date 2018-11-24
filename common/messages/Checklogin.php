<?php
namespace common\messages;
use yii\db\ActiveRecord;
use yii\base\Behavior;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of checklogin
 *
 * @author root
 */
class checklogin extends Behavior{
    //put your code here
      public function events()
    {
        return [
            \yii\web\Application::EVENT_BEFORE_REQUEST => 'beforelogin',
        ];
    }
 public function beforelogin()
    {
     
     
    }
}
