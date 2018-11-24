<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_plan_student".
 *
 * @property integer $allocation_plan_id
 * @property integer $application_id
 * @property double $needness_amount
 * @property double $allocated_amount
 * @property integer $study_year
 *
 * @property Application $application
 * @property AllocationPlan $allocationPlan
 * @property AllocationPlanStudentLoanItem[] $allocationPlanStudentLoanItems
 * @property AllocationPlanLoanItem[] $loanItems
 */
class AllocationPlanStudent extends \yii\db\ActiveRecord {

    const ALLOCATION_TYPE_FIRST_TIME = 1;
    const ALLOCATION_TYPE_BENEFICIARY = 2;

    public $student_fname;
    public $student_mname;
    public $student_lname;
    public $student_hli; //students college/university where he/she study

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return 'allocation_plan_student';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['allocation_plan_id', 'application_id', 'needness_amount', 'study_year', 'programme_id'], 'required'],
            [['allocation_plan_id', 'application_id', 'study_year'], 'integer'],
            [['needness_amount', 'total_allocated_amount'], 'number'],
            [['student_fname', 'student_mname', 'student_lname', 'student_hli', 'comment'], 'safe'],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
            [['allocation_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationPlan::className(), 'targetAttribute' => ['allocation_plan_id' => 'allocation_plan_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'allocation_plan_id' => 'Allocation Plan ID',
            'application_id' => 'Application ID',
            'needness_amount' => 'Needness Amount',
            'allocated_amount' => 'Allocated Amount',
            'study_year' => 'Study Year',
            'student_lname' => 'Last Name',
            'student_mname' => 'Middle Name',
            'student_fname' => 'First Name',
            'comment' => 'Comments'
        ];
    }

    function afterFind() {
        parent::afterFind();
        $sql = " SELECT ";
        $data = \frontend\modules\application\models\User::find()
                        ->join('INNER JOIN', 'applicant', 'applicant.user_id=user.user_id')
                        ->join('INNER JOIN', 'application', 'application.applicant_id=applicant.applicant_id')
                        ->where(['application.application_id' => $this->application_id])->one();
        if ($data) {
            $this->student_fname = $data->firstname;
            $this->student_lname = $data->surname;
            $this->student_mname = $data->middlename;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication() {
        return $this->hasOne(Application::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlan() {
        return $this->hasOne(AllocationPlan::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramme() {
        return $this->hasOne(Programme::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanStudentLoanItems() {
        return $this->hasMany(AllocationPlanStudentLoanItem::className(), ['allocation_plan_id' => 'allocation_plan_id', 'application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItems() {
        return $this->hasMany(AllocationPlanLoanItem::className(), ['loan_item_id' => 'loan_item_id'])->viaTable('allocation_plan_student_loan_item', ['allocation_plan_id' => 'allocation_plan_id', 'application_id' => 'application_id']);
    }

}
