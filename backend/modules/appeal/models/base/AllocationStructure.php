<?php

namespace backend\modules\appeal\models\base;

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
 * @property \backend\modules\appeal\models\AllocationUserStructure[] $allocationUserStructures
 */
class AllocationStructure extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => 1,
            'deleted_at' => 1,
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
        return $this->hasMany(\backend\modules\appeal\models\AllocationUserStructure::className(), ['allocation_structure_id' => 'allocation_structure_id']);
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
