<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "allocation_structure".
 *
 * @property integer $allocation_structure_id
 * @property string $structure_name
 * @property integer $parent_id
 * @property integer $order_level
 * @property integer $status
 *
 * @property \backend\modules\allocation\models\AllocationUserStructure[] $allocationUserStructures
 */
class AllocationStructure extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

   

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'allocationUserStructures'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['structure_name', 'order_level'], 'required'],
            [['parent_id', 'order_level', 'status'], 'integer'],
            [['structure_name'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'allocation_structure';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allocation_structure_id' => 'Allocation Structure ID',
            'structure_name' => 'Structure Name',
            'parent_id' => 'Parent ID',
            'order_level' => 'Order Level',
            'status' => 'Status',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationUserStructures()
    {
        return $this->hasMany(\backend\modules\allocation\models\AllocationUserStructure::className(), ['allocation_structure_id' => 'allocation_structure_id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
   
}
