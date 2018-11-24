<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "admitted_student".
 *
 * @property integer $admitted_student_id
 * @property integer $admission_batch_id
 * @property string $f4indexno
 * @property integer $programme_id
 * @property integer $has_transfered
 *
 * @property AdmissionBatch $admissionBatch
 * @property Programme $programme
 */
class AdmittedStudent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admitted_student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admission_batch_id', 'f4indexno', 'programme_id'], 'safe'],
            [['admission_batch_id', 'programme_id', 'has_transfered'], 'integer'],
            [['f4indexno'], 'string', 'max' => 45],
            [['f4indexno'], 'unique'],
            [['admission_batch_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdmissionBatch::className(), 'targetAttribute' => ['admission_batch_id' => 'admission_batch_id']],
            [['programme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programme::className(), 'targetAttribute' => ['programme_id' => 'programme_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admitted_student_id' => 'Admitted Student ID',
            'admission_batch_id' => 'Admission Batch ID',
            'f4indexno' => 'F4indexno',
            'programme_id' => 'Programme ID',
            'has_transfered' => 'Has Transfered',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionBatch()
    {
        return $this->hasOne(AdmissionBatch::className(), ['admission_batch_id' => 'admission_batch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramme()
    {
        return $this->hasOne(Programme::className(), ['programme_id' => 'programme_id']);
    }
}
