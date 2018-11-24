<?php

namespace backend\modules\disbursement\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "disbursement_schedule".
 *
 * @property integer $disbursement_schedule_id
 * @property string $operator_name
 * @property string $from_amount
 * @property string $to_amount
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $deleted_at
 *
 * @property \backend\modules\disbursement\models\User $createdBy
 * @property \backend\modules\disbursement\models\User $updatedBy
 * @property \backend\modules\disbursement\models\User $deletedBy
 * @property \backend\modules\disbursement\models\DisbursementTaskAssignment[] $disbursementTaskAssignments
 */
class DisbursementSchedule extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

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
            'createdBy',
            'updatedBy',
          
            'disbursementTaskAssignments'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operator_name', 'from_amount'], 'required'],
            
            [['from_amount', 'to_amount'], 'number'],
            [['created_at', 'updated_at', 'created_at', 'created_by'], 'safe'],
            [['created_by', 'updated_by',  ], 'integer'],
            [['operator_name'], 'string', 'max' => 20],
       
                ['to_amount', 'required', 'when' => function ($model) {
                    return $model->operator_name == "Between";
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#disbursementschedule-to_amount').val() == 'Between'; }"],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disbursement_schedule';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'disbursement_schedule_id' => 'Disbursement Schedule ID',
            'operator_name' => 'Operator Name',
            'from_amount' => 'Min Amount',
            'to_amount' => 'Max Amount',
        ];
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
    public function getUpdatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'updated_by']);
    }
        
   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementTaskAssignments()
    {
        return $this->hasMany(\backend\modules\disbursement\models\DisbursementTaskAssignment::className(), ['disbursement_schedule_id' => 'disbursement_schedule_id']);
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
