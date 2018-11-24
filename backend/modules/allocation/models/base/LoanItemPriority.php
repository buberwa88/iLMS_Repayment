<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "loan_item_priority".
 *
 * @property integer $loan_item_priority_id
 * @property integer $academic_year_id
 * @property integer $loan_item_id
 * @property integer $priority_order
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\allocation\models\AcademicYear $academicYear
 * @property \backend\modules\allocation\models\LoanItem $loanItem
 * @property \backend\modules\allocation\models\User $createdBy
 */
class LoanItemPriority extends \yii\db\ActiveRecord {

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
            'loanItem',
            'createdBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['academic_year_id', 'loan_item_id', 'priority_order', 'study_level'], 'required'],
            [['academic_year_id', 'loan_item_id', 'priority_order', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'loan_item_priority';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'loan_item_priority_id' => 'Loan Item Priority',
            'academic_year_id' => 'Academic Year',
            'loan_item_id' => 'Item Name',
            'priority_order' => 'Priority Order',
            'loan_award_percentage' => 'Loan Minimum Award %',
            'loan_item_category' => 'Item Category',
            'study_level' => 'Study Level'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(\backend\modules\allocation\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem() {
        return $this->hasOne(\backend\modules\allocation\models\LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(\backend\modules\allocation\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudyLevel() {
        return $this->hasOne(\backend\modules\application\models\ApplicantCategory::className(), ['applicant_category_id' => 'study_level']);
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
