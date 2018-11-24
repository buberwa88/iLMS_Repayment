<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\User;

/**
 * This is the base model class for table "allocation_user_structure".
 *
 * @property integer $allocation_user_structure_id
 * @property integer $allocation_structure_id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status
 *
 * @property \backend\modules\allocation\models\User $user
 * @property \backend\modules\allocation\models\AllocationStructure $allocationStructure
 * @property \backend\modules\allocation\models\User $createdBy
 * @property \backend\modules\allocation\models\User $updatedBy
 */
class AllocationUserStructure extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

   

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'user',
            'allocationStructure',
            'createdBy',
            'updatedBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_structure_id', 'user_id'], 'required'],
            [['allocation_structure_id', 'user_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'allocation_user_structure';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allocation_user_structure_id' => 'Allocation',
            'allocation_structure_id' => 'Allocation Structure',
            'user_id' => 'Allocation Staff',
            'status' => 'Status',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationStructure()
    {
        return $this->hasOne(\backend\modules\allocation\models\AllocationStructure::className(), ['allocation_structure_id' => 'allocation_structure_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
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
