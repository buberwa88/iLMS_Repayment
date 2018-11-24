<?php

namespace app\models\base;

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
 * @property \app\models\DisbursementSchedule $disbursementSchedule
 * @property \app\models\DisbursementStructure $disbursementStructure
 * @property \app\models\User $createdBy
 * @property \app\models\User $updatedBy
 * @property \app\models\DisbursementTaskDefinition $disbursementTask
 * @property \app\models\User $deletedBy
 */
class DisbursementTaskAssignment extends \yii\db\ActiveRecord
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
            'disbursementSchedule',
            'disbursementStructure',
            'createdBy',
            'updatedBy',
            'disbursementTask',
            'deletedBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_schedule_id', 'disbursement_structure_id', 'disbursement_task_id', 'created_at', 'created_by'], 'required'],
            [['disbursement_schedule_id', 'disbursement_structure_id', 'disbursement_task_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe']
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
            'disbursement_task_assignment_id' => 'Disbursement Task Assignment ID',
            'disbursement_schedule_id' => 'Disbursement Schedule ID',
            'disbursement_structure_id' => 'Disbursement Structure ID',
            'disbursement_task_id' => 'Disbursement Task ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSchedule()
    {
        return $this->hasOne(\app\models\DisbursementSchedule::className(), ['disbursement_schedule_id' => 'disbursement_schedule_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementStructure()
    {
        return $this->hasOne(\app\models\DisbursementStructure::className(), ['disbursement_structure_id' => 'disbursement_structure_id']);
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
    public function getDisbursementTask()
    {
        return $this->hasOne(\app\models\DisbursementTaskDefinition::className(), ['disbursement_task_id' => 'disbursement_task_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(\app\models\User::className(), ['user_id' => 'deleted_by']);
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
