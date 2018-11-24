<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\AdmissionBatch as BaseAdmissionBatch;

/**
 * This is the model class for table "admission_batch".
 */
class AdmissionBatch extends BaseAdmissionBatch {

    const DUMP_TYPE_FILE = 0;
    const DUMP_TYPE_API = 1;

    /**
     * @inheritdoc
     */
    public $file;
    public $updated_at;
    public $updated_by;

    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['academic_year_id', 'batch_number'], 'required'],
            [['academic_year_id', 'created_by'], 'integer'],
//            [['created_at', 'file', 'updated_at', 'updated_by'], 'safe'],
            [['created_at', 'file'], 'safe'],
            [['batch_number'], 'string', 'max' => 10],
            [['batch_desc'], 'string', 'max' => 45]
        ]);
    }

    public static function getAdmissionBatchID($admissionBatchNumber) {
        $condition = ["batch_number" => $admissionBatchNumber];
        return self::find()
                        ->where($condition)
                        ->one();
    }

}
