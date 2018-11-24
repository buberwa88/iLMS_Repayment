<?php

namespace backend\modules\appeal\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\AcademicYear;

/**
 * This is the base model class for table "appeal_plan".
 *
 * @property integer $appeal_plan_id
 * @property integer $academic_year_id
 * @property string $appeal_plan_title
 * @property string $appeal_plan_desc
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\appeal\models\AcademicYear $academicYear
 * @property \backend\modules\appeal\models\AppealQuestion[] $appealQuestions
 */
class AppealPlan extends \yii\db\ActiveRecord
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
            'appealQuestions'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_year_id','appeal_plan_desc','appeal_plan_title','status'], 'required'],
            [['academic_year_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['appeal_plan_title'], 'string', 'max' => 100],
            [['appeal_plan_desc'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appeal_plan';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'appeal_plan_id' => 'Appeal Plan ID',
            'academic_year_id' => 'Academic Year ',
            'appeal_plan_title' => 'Appeal Plan Title',
            'appeal_plan_desc' => 'Appeal Plan Desc',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppealQuestions()
    {
        return $this->hasMany(\backend\modules\appeal\models\AppealQuestion::className(), ['appeal_plan_id' => 'appeal_plan_id']);
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
