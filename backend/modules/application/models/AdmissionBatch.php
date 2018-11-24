<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "admission_batch".
 *
 * @property integer $admission_batch_id
 * @property integer $academic_year_id
 * @property string $batch_number
 * @property string $batch_desc
 * @property string $created_at
 * @property integer $created_by
 *
 * @property AcademicYear $academicYear
 * @property User $createdBy
 * @property AdmittedStudent[] $admittedStudents
 */
class AdmissionBatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admission_batch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_year_id', 'batch_number', 'created_at', 'created_by'], 'safe'],
            [['academic_year_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['batch_number'], 'string', 'max' => 10],
            [['batch_desc'], 'string', 'max' => 45],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admission_batch_id' => 'Admission Batch ID',
            'academic_year_id' => 'Academic Year ID',
            'batch_number' => 'Batch Number',
            'batch_desc' => 'Batch Desc',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(\backend\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmittedStudents()
    {
        return $this->hasMany(AdmittedStudent::className(), ['admission_batch_id' => 'admission_batch_id']);
    }
}
