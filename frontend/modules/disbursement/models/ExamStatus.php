<?php

namespace frontend\modules\disbursement\models;

use Yii;

/**
 * This is the model class for table "exam_status".
 *
 * @property integer $exam_status_id
 * @property string $status_desc
 *
 * @property StudentExamResult[] $studentExamResults
 */
class ExamStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exam_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'exam_status_id' => Yii::t('app', 'Exam Status ID'),
            'status_desc' => Yii::t('app', 'Status Desc'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentExamResults()
    {
        return $this->hasMany(StudentExamResult::className(), ['exam_status_id' => 'exam_status_id']);
    }
}
