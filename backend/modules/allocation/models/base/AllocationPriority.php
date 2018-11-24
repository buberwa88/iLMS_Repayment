<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "allocation_priority".
 *
 * @property integer $allocation_priority_id
 * @property integer $academic_year_id
 * @property integer $source_table
 * @property string $source_table_field
 * @property integer $field_value
 * @property integer $priority_order
 * @property integer $base_line
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\allocation\models\AcademicYear $academicYear
 * @property \backend\modules\allocation\models\User $createdBy
 * @property \backend\modules\allocation\models\User $updatedBy
 * @property \backend\modules\allocation\models\SourceTable $sourceTable
 */
class AllocationPriority extends \yii\db\ActiveRecord
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
            'academicYear',
            'createdBy',
            'updatedBy',
            'sourceTable'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_year_id', 'source_table', 'field_value', 'priority_order', 'baseline', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['source_table_field'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'allocation_priority';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allocation_priority_id' => 'Allocation Priority ID',
            'academic_year_id' => 'Academic Year ID',
            'source_table' => 'Source Table',
            'source_table_field' => 'Source Table Field',
            'field_value' => 'Field Value',
            'priority_order' => 'Priority Order',
            'baseline' => 'Baseline',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(\backend\modules\allocation\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\backend\modules\allocation\models\User::className(), ['user_id' => 'created_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\backend\modules\allocation\models\User::className(), ['user_id' => 'updated_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceTable()
    {
        return $this->hasOne(\backend\modules\allocation\models\SourceTable::className(), ['source_table_id' => 'source_table']);
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
