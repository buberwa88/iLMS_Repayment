<?php

namespace app\models\base;

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
 * @property \app\models\User $createdBy
 * @property \app\models\User $updatedBy
 * @property \app\models\User $deletedBy
 * @property \app\models\DisbursementTaskAssignment[] $disbursementTaskAssignments
 */
class DisbursementSchedule extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->identity->user_id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
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
            'deletedBy',
            'disbursementTaskAssignments'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operator_name', 'from_amount', 'to_amount', 'created_at', 'created_by'], 'required'],
            [['from_amount', 'to_amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['operator_name'], 'string', 'max' => 10],
            [['deleted_by'], 'unique']
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
            'from_amount' => 'From Amount',
            'to_amount' => 'To Amount',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\User::className(), ['user_id' => 'created_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\app\models\User::className(), ['user_id' => 'updated_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(\app\models\User::className(), ['user_id' => 'deleted_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementTaskAssignments()
    {
        return $this->hasMany(\app\models\DisbursementTaskAssignment::className(), ['disbursement_schedule_id' => 'disbursement_schedule_id']);
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
