<?php

namespace common\models;

use Yii;
use backend\modules\allocation\models\Programme as BaseProgramme;

/**
 * This is the model class for table "learning_institution".
 */
class Programme extends BaseProgramme {

    static function getProgrammeName($programme_id) {
        $data = self::find()->where(['programme_id' => $programme_id])->one();
        if ($data) {
            return $data->programme_name;
        }
        return NULL;
    }

}
