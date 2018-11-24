<?php

namespace backend\modules\disbursement\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "disbursement_user_task".
 *
 * @property integer $disbursement_user_task_id
 * @property integer $disbursement_structure_id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $deleted_at
 *
 * @property \backend\modules\disbursement\models\DisbursementStructure $disbursementStructure
 * @property \backend\modules\disbursement\models\User $user
 * @property \backend\modules\disbursement\models\User $createdBy
 * @property \backend\modules\disbursement\models\User $updatedBy
 * @property \backend\modules\disbursement\models\User $deletedBy
 */
class DisbursementUserTask extends \yii\db\ActiveRecord
{
 

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
            'disbursementStructure',
            'user',
            'createdBy',
            'updatedBy',
       
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_structure_id', 'user_id'], 'required'],
            [['disbursement_structure_id', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at','created_at', 'created_by'], 'safe']
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
            'disbursement_user_structure_id' => 'Disbursement User Task ',
            'disbursement_structure_id' => 'Disbursement Structure',
            'user_id' => 'Staff Name',
        ];
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
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'user_id']);
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
