<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "learning_institution_fee".
 *
 * @property integer $learning_institution_fee_id
 * @property integer $learning_institution_id
 * @property integer $academic_year_id
 * @property double $annual_fee
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\allocation\models\AcademicYear $academicYear
 * @property \backend\modules\allocation\models\LearningInstitution $learningInstitution
 * @property \backend\modules\allocation\models\User $createdBy
 */
class LearningInstitutionFee extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    public function __construct() {
        parent::__construct();
    }

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames() {
        return [
            'academicYear',
            'learningInstitution',
            'createdBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['learning_institution_id', 'academic_year_id','study_level', 'fee_amount'], 'required'],
            [['learning_institution_id', 'academic_year_id', 'created_by', 'updated_by'], 'integer'],
            [['study_level', 'fee_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'learning_institution_fee';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'learning_institution_fee_id' => 'Learning Institution Fee ',
            'learning_institution_id' => 'Learning Institution ',
            'academic_year_id' => 'Academic Year ',
            'study_level' => 'Study Level',
            'fee_amount' => 'Fee Amount'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution() {
        return $this->hasOne(\backend\modules\allocation\models\LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors() {
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
