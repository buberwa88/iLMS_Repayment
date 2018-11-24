<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\modules\allocation\models;

/**
 * Description of SystemSetting
 *
 * @author charles
 */
class SystemSetting extends \backend\models\SystemSetting{
    //put your code here
    
    static function getItemSettingsValueByCodeemSettingByCode($code){
        $data=self::find()->where(['setting_code'=>$code])->one();
        if($data){
            return $data->setting_value;
        }
    }
}

