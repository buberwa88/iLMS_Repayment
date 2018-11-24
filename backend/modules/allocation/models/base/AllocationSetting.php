<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "allocation_setting".
 *
 * @property integer $allocation_setting_id
 * @property integer $academic_year_id
 * @property integer $loan_item_id
 * @property integer $priority_order
 * @property string $created_at
 * @property integer $created_by
 *
 * @property \backend\modules\allocation\models\AcademicYear $academicYear
 * @property \backend\modules\allocation\models\LoanItem $loanItem
 * @property \backend\modules\allocation\models\User $createdBy
 */
class AllocationSetting extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;
 

    public function __construct(){
      
    }

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'academicYear',
            'loanItem',
            'createdBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_year_id', 'loan_item_id', 'priority_order'], 'required'],
            [['academic_year_id', 'loan_item_id', 'priority_order', 'created_by'], 'integer'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'allocation_setting';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allocation_setting_id' => 'Allocation Setting',
            'academic_year_id' => 'Academic Year',
            'loan_item_id' => 'Loan Item',
            'priority_order' => 'Priority Order',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem()
    {
        return $this->hasOne(\backend\modules\allocation\models\LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
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
