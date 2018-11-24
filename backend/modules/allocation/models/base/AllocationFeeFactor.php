<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "allocation_fee_factor".
 *
 * @property integer $allocation_fee_factor_id
 * @property integer $academic_year_id
 * @property string $operator_name
 * @property string $min_amount
 * @property string $max_amount
 * @property string $factor_value
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\allocation\models\AcademicYear $academicYear
 * @property \backend\modules\allocation\models\User $createdBy
 * @property \backend\modules\allocation\models\User $updatedBy
 */
class AllocationFeeFactor extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'academicYear',
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
            [['academic_year_id', 'factor_value'], 'required'],
            [['academic_year_id', 'created_by', 'updated_by'], 'integer'],
            [['min_amount', 'max_amount', 'factor_value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['operator_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'allocation_fee_factor';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allocation_fee_factor_id' => 'Allocation Fee Factor ID',
            'academic_year_id' => 'Academic Year',
            'operator_name' => 'Operator Name',
            'min_amount' => 'Min Amount',
            'max_amount' => 'Max Amount',
            'factor_value' => 'Factor Value',
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
   public function getFeeFactor($studentfee,$academic_year_id){
       $fee_factor="M";
       $model=  AllocationFeeFactor::findAll(["academic_year_id"=>$academic_year_id]);
      if(count($model)>0){
       foreach ($model as $models){
                 if($models["operator_name"]=="Between"){
                     if($models["min_amount"]<$studentfee&&$studentfee<=$models["max_amount"]){
                       $fee_factor=$models["factor_value"]; 
                         
                     }
                 }
                 else{
                    if($models["min_amount"]<$studentfee){
                       $fee_factor=$models["factor_value"]; 
                            
                     }  
                 }
       }
      }
      return $fee_factor;
   }
}
