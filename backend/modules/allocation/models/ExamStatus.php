<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "exam_status".
 *
 * @property integer $exam_status_id
 * @property string $status_desc
 *
 * @property StudentExamResult[] $studentExamResults
 */
class ExamStatus extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'exam_status';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['status_desc'], 'required'],
            [['status_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'exam_status_id' => 'Exam Status ID',
            'status_desc' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentExamResults() {
        return $this->hasMany(StudentExamResult::className(), ['exam_status_id' => 'exam_status_id']);
    }

    public static function getExamStatusID($programmeCode) {
        $condition = ["status_desc" => $programmeCode];
        return self::find()
                        ->where($condition)
                        ->one();
    }

    public static function getExamStatusIDByName($StatusName) {
        $condition = ["status_desc" => $StatusName];
        $data = self::find()->select('exam_status_id')
                ->where($condition)
                ->one();
        if ($data) {
            return $data->exam_status_id;
        }
        return NULL;
    }

}
