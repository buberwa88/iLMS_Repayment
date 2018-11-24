<?php

namespace backend\modules\disbursement\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "disbursement_task_assignment".
 *
 * @property integer $disbursement_task_assignment_id
 * @property integer $disbursement_schedule_id
 * @property integer $disbursement_structure_id
 * @property integer $disbursement_task_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $deleted_at
 *
 * @property \backend\modules\disbursement\models\\DisbursementSchedule $disbursementSchedule
 * @property \backend\modules\disbursement\models\\DisbursementStructure $disbursementStructure
 * @property \backend\modules\disbursement\models\\User $createdBy
 * @property \backend\modules\disbursement\models\\User $updatedBy
 * @property \backend\modules\disbursement\models\\DisbursementTaskDefinition $disbursementTask
 * @property \backend\modules\disbursement\models\\User $deletedBy
 */
class DisbursementTaskAssignment extends \yii\db\ActiveRecord
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
            'disbursementSchedule',
            'disbursementStructure',
            'createdBy',
            'updatedBy',
            'disbursementTask',
        
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_schedule_id', 'disbursement_structure_id', 'disbursement_task_id'], 'required'],
            [['disbursement_schedule_id', 'disbursement_structure_id', 'disbursement_task_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_at', 'created_by'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disbursement_task_assignment';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'disbursement_task_assignment_id' => 'Disbursement Task Assignment',
            'disbursement_schedule_id' => 'Disbursement Schedule',
            'disbursement_structure_id' => 'Disbursement Structure',
            'disbursement_task_id' => 'Disbursement Task',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSchedule()
    {
        return $this->hasOne(\backend\modules\disbursement\models\DisbursementSchedule::className(), ['disbursement_schedule_id' => 'disbursement_schedule_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementStructure()
    {
        return $this->hasOne(\backend\modules\disbursement\models\DisbursementStructure::className(), ['disbursement_structure_id' => 'disbursement_structure_id']);
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
