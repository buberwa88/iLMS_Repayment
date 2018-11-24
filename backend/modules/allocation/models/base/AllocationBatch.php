<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "allocation_batch".
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
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_canceled
 * @property string $cancel_comment
 * @property integer $disburse_status
 * @property string $disburse_comment
 *
 * @property \backend\modules\allocation\models\Allocation[] $allocations
 * @property \backend\modules\allocation\models\AcademicYear $academicYear
 * @property \backend\modules\allocation\models\User $createdBy
 * @property \backend\modules\allocation\models\DisbursementBatch[] $disbursementBatches
 */
class AllocationBatch extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;
 

    public function __construct(){
        parent::__construct();
       
    }

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'allocations',
            'academicYear',
            'createdBy',
            'disbursementBatches'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contained_student','batch_desc'], 'required'],
            [['batch_number', 'academic_year_id', 'is_approved', 'created_by', 'updated_by', 'is_canceled', 'disburse_status'], 'integer'],
            [['available_budget'], 'number'],
            [['approval_comment', 'cancel_comment'], 'string'],
            [['created_at','review_at', 'updated_at'], 'safe'],
            [['batch_desc'], 'string', 'max' => 45],
            [['disburse_comment'], 'string', 'max' => 300]
        ];
    }

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
    public function attributeLabels()
    {
        return [
            'allocation_batch_id' => 'Allocation Batch',
            'batch_number' => 'Batch Number',
            'allocation_history_id'=>'Allocation history',
            'batch_desc' => 'Batch Desc',
            'academic_year_id' => 'Academic Year',
            'available_budget' => 'Available Budget',
            'is_approved' => 'Is Approved',
            'approval_comment' => 'Approval Comment',
            'is_canceled' => 'Is Canceled',
            'cancel_comment' => 'Cancel Comment',
            'disburse_status' => 'Disburse Status',
            'disburse_comment' => 'Disburse Comment',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocations()
    {
        return $this->hasMany(\backend\modules\allocation\models\Allocation::className(), ['allocation_batch_id' => 'allocation_batch_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
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
    public function getDisbursementBatches()
    {
        return $this->hasMany(\backend\modules\allocation\models\DisbursementBatch::className(), ['allocation_batch_id' => 'allocation_batch_id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => \Yii::$app->user->identity->user_id,
            ],
        ];
    }
}
