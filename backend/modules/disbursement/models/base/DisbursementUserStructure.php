<?php

namespace backend\modules\disbursement\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "disbursement_user_structure".
 *
 * @property integer $disbursement_user_structure_id
 * @property integer $disbursement_structure_id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $deleted_at
 * @property integer $status
 *
 * @property \backend\modules\disbursement\models\DisbursementPayoutlistMovement[] $disbursementPayoutlistMovements
 * @property \backend\modules\disbursement\models\DisbursementStructure $disbursementStructure
 * @property \backend\modules\disbursement\models\User $user
 * @property \backend\modules\disbursement\models\User $createdBy
 * @property \backend\modules\disbursement\models\User $updatedBy
 * @property \backend\modules\disbursement\models\User $deletedBy
 */
class DisbursementUserStructure extends \yii\db\ActiveRecord
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
            'disbursementPayoutlistMovements',
            'disbursementStructure',
            'user',
            'createdBy',
            'updatedBy',
            'deletedBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_structure_id', 'user_id', 'created_at', 'created_by'], 'required'],
            [['disbursement_structure_id', 'user_id', 'created_by', 'updated_by', 'deleted_by', 'status'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disbursement_user_structure';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'disbursement_user_structure_id' => 'Disbursement User Structure ID',
            'disbursement_structure_id' => 'Disbursement Structure ID',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementPayoutlistMovements()
    {
        return $this->hasMany(\backend\modules\disbursement\models\DisbursementPayoutlistMovement::className(), ['from_officer' => 'disbursement_user_structure_id']);
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
    public function getUser()
    {
        return $this->hasOne(\backend\modules\disbursement\models\User::className(), ['user_id' => 'user_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\backend\modules\disbursement\models\User::className(), ['user_id' => 'created_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\backend\modules\disbursement\models\User::className(), ['user_id' => 'updated_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(\backend\modules\disbursement\models\User::className(), ['user_id' => 'deleted_by']);
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
