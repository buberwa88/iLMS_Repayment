<?php
namespace frontend\modules\appeal\helpers;

class ComplaintHelper {

    private static $status = ["1"=>"submited", "2"=>"in-progress", "3"=>"completed", "4"=>"re-submited"];

    public static function decodeStatusFromNumber($number){
        
        if(isset(self::$status[$number])){
            return self::$status[$number];
        }

        return null;
    }

    public static function decodeStatusFromValue($value){
        
        $index = array_search($value, self::$status);
        
        if($index > -1){
            return $index;
        }
    
        return null;
    }
    
}