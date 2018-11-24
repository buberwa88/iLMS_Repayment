<?php

namespace backend\modules\disbursement\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "disbursement_payoutlist_movement".
 *
 * @property integer $movement_id
 * @property integer $disbursements_batch_id
 * @property integer $from_officer
 * @property integer $to_officer
 * @property integer $movement_status
 * @property integer $disbursement_task_id
 * @property string $signature
 * @property string $date_out
 * @property string $comment
 *
 * @property \backend\modules\disbursement\models\DisbursementUserStructure $toOfficer
 * @property \backend\modules\disbursement\models\DisbursementUserStructure $fromOfficer
 * @property \backend\modules\disbursement\models\DisbursementBatch $disbursementsBatch
 * @property \backend\modules\disbursement\models\DisbursementTaskDefinition $disbursementTask
 */
class PayoutlistMovement extends \yii\db\ActiveRecord
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
            'toOfficer',
            'fromOfficer',
            'disbursementsBatch',
            'disbursementTask'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursements_batch_id', 'from_officer', 'to_officer'], 'required'],
            [['disbursements_batch_id', 'from_officer', 'to_officer', 'movement_status', 'disbursement_task_id'], 'integer'],
            [['date_out'], 'safe'],
            [['comment'], 'string'],
            [['signature'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disbursement_payoutlist_movement';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'movement_id' => 'Movement ID',
            'disbursements_batch_id' => 'Disbursements Batch ID',
            'from_officer' => 'From Officer',
            'to_officer' => 'To Officer',
            'movement_status' => 'Movement Status',
            'disbursement_task_id' => 'Disbursement Task ID',
            'signature' => 'Signature',
            'date_out' => 'Date Out',
            'comment' => 'Comment',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToOfficer()
    {
        return $this->hasOne(\backend\modules\disbursement\models\DisbursementUserStructure::className(), ['disbursement_user_structure_id' => 'to_officer']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromOfficer()
    {
        return $this->hasOne(\backend\modules\disbursement\models\DisbursementUserStructure::className(), ['disbursement_user_structure_id' => 'from_officer']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementsBatch()
    {
        return $this->hasOne(\backend\modules\disbursement\models\DisbursementBatch::className(), ['disbursement_batch_id' => 'disbursements_batch_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementTask()
    {
        return $this->hasOne(\backend\modules\disbursement\models\DisbursementTaskDefinition::className(), ['disbursement_task_id' => 'disbursement_task_id']);
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
