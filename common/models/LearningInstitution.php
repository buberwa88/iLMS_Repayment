<?php

namespace common\models;

use Yii;
use backend\modules\allocation\models\LearningInstitution as BaseLearningInstitution;

/**
 * This is the model class for table "learning_institution".
 */
class LearningInstitution extends BaseLearningInstitution {

//    static function getNameById($id) {
//        $data = self::find()->select('institution_name')->where(['learning_institution_id' => $id])->one();
//        if ($data) {
//            return $data->institution_name;
//        }
//        return NULL;
//    }
}
