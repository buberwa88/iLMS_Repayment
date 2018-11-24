<?php

namespace frontend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_batch".
 *
 * @property integer $allocation_batch_id
 * @property integer $batch_number
 * @property string $batch_desc
 * @property integer $academic_year_id
 * @property double $available_budget
 * @property integer $is_approved
 * @property string $approval_comment
 * @property string $created_at
 * @property integer $created_by
 * @property integer $is_canceled
 * @property string $cancel_comment
 *
 * @property Allocation[] $allocations
 * @property AcademicYear $academicYear
 * @property User $createdBy
 * @property DisbursementBatch[] $disbursementBatches
 */
class AllocationBatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'allocation_batch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_batch_id', 'batch_number', 'batch_desc', 'academic_year_id', 'available_budget', 'created_at', 'created_by'], 'required'],
            [['allocation_batch_id', 'batch_number', 'academic_year_id', 'is_approved', 'created_by', 'is_canceled'], 'integer'],
            [['available_budget'], 'number'],
            [['approval_comment', 'cancel_comment'], 'string'],
            [['created_at'], 'safe'],
            [['batch_desc'], 'string', 'max' => 45],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allocation_batch_id' => Yii::t('app', 'Allocation Batch ID'),
            'batch_number' => Yii::t('app', 'Batch Number'),
            'batch_desc' => Yii::t('app', 'Batch Desc'),
            'academic_year_id' => Yii::t('app', 'Academic Year ID'),
            'available_budget' => Yii::t('app', 'Available Budget'),
            'is_approved' => Yii::t('app', 'Is Approved'),
            'approval_comment' => Yii::t('app', 'Approval Comment'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'is_canceled' => Yii::t('app', 'Is Canceled'),
            'cancel_comment' => Yii::t('app', 'Cancel Comment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocations()
    {
        return $this->hasMany(Allocation::className(), ['allocation_batch_id' => 'allocation_batch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(\frontend\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementBatches()
    {
        return $this->hasMany(DisbursementBatch::className(), ['allocation_batch_id' => 'allocation_batch_id']);
    }
}
