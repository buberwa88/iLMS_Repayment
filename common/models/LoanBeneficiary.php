<?php

namespace common\models;

use Yii;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Application;
use frontend\modules\repayment\models\Employer;
//use frontend\modules\application\models\User;
use \common\models\User;

/**
 * This is the model class for table "loan_beneficiary".
 *
 * @property integer $loan_beneficiary_id
 * @property string $firstname
 * @property string $middlename
 * @property string $surname
 * @property string $f4indexno
 * @property string $NID
 * @property string $date_of_birth
 * @property integer $place_of_birth
 * @property integer $learning_institution_id
 * @property string $postal_address
 * @property string $physical_address
 * @property string $phone_number
 * @property string $email_address
 * @property string $password
 *
 * @property Ward $placeOfBirth
 * @property LearningInstitution $learningInstitution
 */
class LoanBeneficiary extends \yii\db\ActiveRecord {

//loan confirmation status
    const LOAN_STATEMENT_NOT_CONFIRMED = 0;
    const LOAN_STATEMENT_CONFIRMED = 1;
///liquidation letter status
    const LOAN_LIQUIDATION_NOT_ISSUED = 0;
    const LOAN_LIQUIDATION_ISSUED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'loan_beneficiary';
    }

    /**
     * @inheritdoc
     */
    public $confirm_password;
    public $region;
    public $district;
    public $ward_id;
    public $operation;
    public $check_search;
    public $start_date;
    public $end_date;
    public $loan_no;
    public $name;
    public $schedule_principal_amount;
    
    public function rules() {
        return [
            [['firstname', 'middlename', 'surname', 'date_of_birth', 'place_of_birth', 'learning_institution_id', 'physical_address', 'phone_number', 'email_address', 'password', 'district', 'confirm_password', 'sex', 'region'], 'required', 'on' => 'loanee_registration'],
            [['start_date', 'end_date'], 'required', 'on' => 'reprocessloan'],
            ['password', 'string', 'length' => [8, 24]],
            [['date_of_birth', 'created_at', 'updated_at', 'updated_by', 'sex', 'region', 'applicant_id', 'NID', 'ward_id', 'operation', 'check_search', 'start_date', 'end_date', 'name', 'loan_confirmation_status', 'liquidation_letter_status','schedule_principal_amount','schedule_penalty','schedule_laf','schedule_vrf','schedule_total_loan_amount','schedule_start_date','schedule_end_date','monthly_installment'], 'safe'],
            [['place_of_birth', 'learning_institution_id', 'phone_number', 'applicant_id'], 'integer'],
            [['firstname', 'middlename', 'surname', 'f4indexno'], 'string', 'max' => 45],
            [['firstname', 'middlename', 'surname'], 'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/', 'message' => 'Only Characters  Are Allowed...'],
            [['NID', 'postal_address'], 'string', 'max' => 30],
            [['physical_address', 'email_address'], 'string', 'max' => 100],
            [['phone_number'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            //[['email_address'], 'unique','message'=>'Email Address Exist'],
            ['email_address', 'email'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords must be retyped exactly", 'on' => 'loanee_registration'],
            [['place_of_birth'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Ward::className(), 'targetAttribute' => ['place_of_birth' => 'ward_id']],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'loan_beneficiary_id' => 'Loan Beneficiary ID',
            'firstname' => 'First Name',
            'middlename' => 'Middle Name',
            'surname' => 'Last Name',
            'name' => 'Name',
            'f4indexno' => 'Form IV Index No.',
            'NID' => 'National Identification No.',
            'date_of_birth' => 'Date Of Birth',
            'place_of_birth' => 'Place Of Birth(Ward)',
            'learning_institution_id' => 'Learning Institution',
            'postal_address' => 'Postal Address',
            'physical_address' => 'Physical Address',
            'phone_number' => 'Phone Number',
            'email_address' => 'Email Address',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'district' => 'Place of Birth(District)',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'updated_by' => 'Updated by',
            //'place_of_birth'=>'Ward',
            'sex' => 'Sex',
            'region' => 'Region',
            'applicant_id' => 'applicant_id',
            'ward_id' => 'Ward',
            'operation' => 'operation',
            'start_date' => 'From',
            'end_date' => 'To',
            'loan_no' => 'Loan Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant() {
        return $this->hasOne(\frontend\modules\application\models\Applicant::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceOfBirth() {
        return $this->hasOne(\backend\modules\application\models\Ward::className(), ['ward_id' => 'place_of_birth']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution() {
        return $this->hasOne(\backend\modules\application\models\LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    public function getUpdatedBy() {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'updated_by']);
    }

    public function getUser($applicantID) {
        $details_applicant = Applicant::findBySql("SELECT a.user_id AS user_id,b.username AS username FROM applicant a INNER JOIN user b ON a.user_id=b.user_id  WHERE  a.applicant_id='$applicantID' ORDER BY a.applicant_id DESC")->one();
        $user_id = $details_applicant->user_id;
        $value = (count($user_id) == 0) ? '0' : $details_applicant;
        return $value;
    }

    public function updateUserBasicInfo($username, $password, $auth_key, $user_id) {
        User::updateAll(['username' => $username, 'password_hash' => $password, 'auth_key' => $auth_key, 'status' => '0'], 'user_id ="' . $user_id . '"');
    }

    public function getApplicantDetails($applcantF4IndexNo, $NIN) {
        if ($applcantF4IndexNo != '' && $NIN != '') {

            $details1 = \frontend\modules\application\models\Applicant::findBySql("SELECT * FROM applicant  WHERE  f4indexno='$applcantF4IndexNo' AND NID='$NIN' ORDER BY applicant_id DESC")->one();
            $applicantResult = $details1->applicant_id;

            $value1 = (count($applicantResult) == 0) ? '0' : '1';
            if ($value1 == 0) {
                $details2 = \frontend\modules\application\models\Applicant::findBySql("SELECT * FROM applicant  WHERE f4indexno='$applcantF4IndexNo' ORDER BY applicant_id DESC")->one();
                $applicantResult2 = $details2->applicant_id;
                $value2 = (count($applicantResult2) == 0) ? '0' : '1';
                if ($value2 == 0) {
                    $details3 = \frontend\modules\application\models\Applicant::findBySql("SELECT * FROM applicant  WHERE NID='$NIN' ORDER BY applicant_id DESC")->one();
                    $applicantResult3 = $details3->applicant_id;
                    $value3 = (count($applicantResult3) == 0) ? '0' : '1';
                    if ($value3 == 1) {
                        $resultsFound = $applicantResult3;
                    } else {
                        $resultsFound = $applicantResult3;
                    }
                } else {
                    $resultsFound = $details2;
                }
            } else {
                $resultsFound = $details1;
            }
        } else if ($applcantF4IndexNo == '' && $NIN != '') {
            $details_4 = \frontend\modules\application\models\Applicant::find()
                            ->where(['NID' => $NIN])
                            ->orderBy('applicant_id DESC')
                            ->limit(1)->one();
            $resultsFound = $details_4;
        } else if ($applcantF4IndexNo != '' && $NIN == '') {
            $details_5 = \frontend\modules\application\models\Applicant::find()
                            ->where(['f4indexno' => $applcantF4IndexNo])
                            ->orderBy('applicant_id DESC')
                            ->limit(1)->one();
            $resultsFound = $details_5;
        } else if ($applcantF4IndexNo == '' && $NIN == '') {
            $resultsFound = "";
        }
        return $resultsFound;
    }

    public function getApplicantDetailsUsingNonUniqueIdentifiers($f4indexno, $dateofbirth, $placeofbirth, $learningInstitution) {
        $details_applicant = Applicant::findBySql("SELECT * FROM applicant INNER JOIN user ON user.user_id=applicant.user_id INNER JOIN application ON application.applicant_id=applicant.applicant_id INNER JOIN programme ON programme.programme_id=application.programme_id INNER JOIN ward ON ward.ward_id=applicant.place_of_birth "
                        . "WHERE  applicant.date_of_birth='$dateofbirth' AND applicant.f4indexno='$f4indexno' AND ward.ward_id='$placeofbirth' AND programme.learning_institution_id ='$learningInstitution' ORDER BY applicant.applicant_id DESC")->one();
        if (count($details_applicant) > 0) {
            $applicant_idR = $details_applicant->applicant_id;
        } else {
            $applicant_idR = 0;
        }
        return $applicant_idR;
    }

    public static function getApplicantDetailsUsingApplicantID($id) {
        $details_applicant = Applicant::findBySql("SELECT * FROM applicant INNER JOIN user ON user.user_id=applicant.user_id INNER JOIN application ON application.applicant_id=applicant.applicant_id INNER JOIN programme ON programme.programme_id=application.programme_id INNER JOIN ward ON ward.ward_id=applicant.place_of_birth "
                        . "WHERE  applicant.applicant_id='$id' ORDER BY applicant.applicant_id DESC")->one();
        if (count($details_applicant) > 0) {
            $applicant_idR = $details_applicant;
        } else {
            $applicant_idR = 0;
        }
        return $applicant_idR;
    }

    public function getApplicantLearningInstitution($applicantID) {
        $details_application = Application::findBySql("SELECT * FROM application INNER JOIN  programme ON programme.programme_id=application.programme_id  "
                        . "WHERE application.applicant_id='$applicantID' ORDER BY application.applicant_id DESC")->one();
        if (count($details_application) > 0) {
            $institutionDetail = $details_application;
        } else {
            $institutionDetail = 0;
        }
        return $institutionDetail;
    }

    public function getUserIDFromEmployer($employerID) {
        $results = Employer::find()->where(['employer_id' => $employerID])->one();
        if (count($results) > 0) {
            $userID = $results;
        } else {
            $userID = 0;
        }
        return $userID;
    }

    public function updateUserVerifyEmail($user_id) {
        User::updateAll(['email_verified' => '1'], 'user_id ="' . $user_id . '"');
    }

    public function updateUserActivateAccount($user_id) {
        User::updateAll(['status' => 10, 'activation_email_sent' => 1], 'user_id ="' . $user_id . '"');
    }

    public function getUserDetailsFromUserID($userID) {
        $results_user = User::find()->where(['user_id' => $userID])->one();
        if (count($results_user) > 0) {
            $userID = $results_user;
        } else {
            $userID = 0;
        }
        return $userID;
    }

    public function getUserDetailsGeneral($username) {
        $userDetails = User::findBySql("SELECT * FROM user "
                        . "WHERE user.email_address='$username' OR user.username='$username'")->one();
        if (count($userDetails) > 0) {
            $results = $userDetails;
        } else {
            $results = 0;
        }
        if ($results == 0) {

            $userDetailsApplicant = Applicant::findBySql("SELECT * FROM applicant "
                            . "WHERE f4indexno='$username'")->one();
            if (count($userDetailsApplicant) > 0) {
                $results_userID = $userDetailsApplicant->user_id;
                $userDetailsApplicant2 = User::findBySql("SELECT * FROM user "
                                . "WHERE user_id='$results_userID'")->one();
                if (count($userDetailsApplicant2) > 0) {
                    $results_final = $userDetailsApplicant2;
                } else {
                    $results_final = 0;
                }
            } else {
                $results_final = 0;
            }
            return $results_final;
        } else {
            return $results;
        }
    }

    public function updateEmployerVerifiedEmail($employerID, $verification_status) {
        Employer::updateAll(['verification_status' => $verification_status], 'employer_id ="' . $employerID . '"');
    }

    public function updateBeneficiaryVerifiedEmail($loan_beneficiary_id, $verification_status) {
        LoanBeneficiary::updateAll(['email_verified' => $verification_status], 'loan_beneficiary_id="' . $loan_beneficiary_id . '"');
    }

    public function getBeneficiaryDetails($loan_beneficiary_id) {
        $resultsBeneficiary = LoanBeneficiary::findBySql("SELECT * FROM loan_beneficiary "
                        . "WHERE loan_beneficiary_id='$loan_beneficiary_id'")->one();
        if (count($resultsBeneficiary) > 0) {
            $results_final = $resultsBeneficiary;
        } else {
            $results_final = 0;
        }
        return $results_final;
    }

    public function updateUserBasicInfo3($username, $password, $auth_key, $user_id) {
        User::updateAll(['username' => $username, 'password_hash' => $password, 'auth_key' => $auth_key, 'status' => '10'], 'user_id ="' . $user_id . '"');
    }

    public function deactivateUser($user_id, $statusD, $updatedBy) {
        $updatedAt = date("Y-m-d H:i:s");
        User::updateAll(['status' => $statusD, 'updated_at' => $updatedAt, 'updated_by' => $updatedBy], 'user_id ="' . $user_id . '"');
    }

    public function findApplicant($id) {
        if (($model = Applicant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public static function getAcademicYearTrend($applicant_id) {
        $academicYearTrend = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id',disbursement.status_date AS 'status_date' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.status='8' AND  disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement_batch.academic_year_id ASC")->all();
        return $academicYearTrend;
    }

    public static function getAcademicYearTrendLoanApplicantThroughEmployer($applicant_id) {
        $academicYearTrend = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id',disbursement.status_date AS 'status_date' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.status='8' AND  disbursement_batch.is_approved='1' AND disbursement_batch.employer_id > '0' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement_batch.academic_year_id ASC")->all();
        return $academicYearTrend;
    }

    public static function getLoanItemsProvided($applicant_id) {
        $resultLoanItems = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND (disbursement.status='8' OR disbursement.status='10') AND disbursement_batch.employer_id IS NULL GROUP BY disbursement.loan_item_id ORDER BY disbursement.loan_item_id ASC")->all();

        return $resultLoanItems;
    }

    public static function getLoanItemsProvidedThroughEmployer($applicant_id) {
        $resultLoanItems = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND (disbursement.status='8' OR disbursement.status='10') AND disbursement_batch.employer_id > '0' GROUP BY disbursement.loan_item_id ORDER BY disbursement.loan_item_id ASC")->all();

        return $resultLoanItems;
    }

    public static function getAmountPerLoanItemsProvided($applicant_id, $loanItem, $academic_yearID) {
        $amountPerLoanItemProvided = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.loan_item_id='$loanItem' AND  disbursement_batch.academic_year_id='$academic_yearID' AND disbursement_batch.employer_id IS NULL GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_batch_id ASC")->one();

        return $amountPerLoanItemProvided;
    }

    public static function getAmountPerLoanItemsProvidedThroughEmployer($applicant_id, $loanItem, $academic_yearID) {
        $amountPerLoanItemProvided = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.loan_item_id='$loanItem' AND  disbursement_batch.academic_year_id='$academic_yearID' AND disbursement_batch.employer_id > '0' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_batch_id ASC")->one();

        return $amountPerLoanItemProvided;
    }

    public static function getAmountSubtotal($applicant_id) {
        $amountSubTotal = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND (disbursement.status='5' OR disbursement.status='2') AND disbursement_batch.employer_id IS NULL GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_id ASC")->all();
        return $amountSubTotal;
    }

    public static function getLoanItemsReturned($applicant_id) {
        $loanItemReturns = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.status='10' AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL GROUP BY disbursement.loan_item_id  ORDER BY disbursement.loan_item_id ASC")->all();
        return $loanItemReturns;
    }

    public static function getLoanItemsReturnedThroughEmployer($applicant_id) {
        $loanItemReturns = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.status='10' AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id > '0' GROUP BY disbursement.loan_item_id  ORDER BY disbursement.loan_item_id ASC")->all();
        return $loanItemReturns;
    }

    public static function getLoanItemsAmountReturned($applicant_id, $returnedItem, $academic_yearIDQ) {
        $amount1Return = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.loan_item_id='$returnedItem' AND disbursement.status='10' AND disbursement_batch.academic_year_id='$academic_yearIDQ' AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL GROUP BY disbursement_batch.academic_year_id  ORDER BY disbursement.disbursement_batch_id ASC")->one();
        return $amount1Return;
    }

    public static function getLoanItemsAmountReturnedThroughEmployer($applicant_id, $returnedItem, $academic_yearIDQ) {
        $amount1Return = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.loan_item_id='$returnedItem' AND disbursement.status='10' AND disbursement_batch.academic_year_id='$academic_yearIDQ' AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id > '0' GROUP BY disbursement_batch.academic_year_id  ORDER BY disbursement.disbursement_batch_id ASC")->one();
        return $amount1Return;
    }

    public static function getAmountSubtotalReturned($applicant_id, $academic_yearIDQR) {
        $amountSubTotalReturned = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.status='10' AND disbursement_batch.academic_year_id='$academic_yearIDQR' GROUP BY disbursement_batch.academic_year_id AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL ORDER BY disbursement.disbursement_id ASC")->one();
        return $amountSubTotalReturned;
    }

    public static function getAmountSubtotalReturnedThroughEmployer($applicant_id, $academic_yearIDQR) {
        $amountSubTotalReturned = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.status='10' AND disbursement_batch.academic_year_id='$academic_yearIDQR' GROUP BY disbursement_batch.academic_year_id AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id > '0' ORDER BY disbursement.disbursement_id ASC")->one();
        return $amountSubTotalReturned;
    }

    public static function getAmountSubtotalPerAccademicY($applicant_id, $academic_yearIDQR) {
        $amountSubTotalPerAcDemic = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND (disbursement.status='8' OR disbursement.status='10') AND disbursement_batch.academic_year_id='$academic_yearIDQR' AND disbursement_batch.employer_id IS NULL GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_id ASC")->one();
        return $amountSubTotalPerAcDemic;
    }

    public static function getAmountSubtotalPerAccademicYThroughEmployer($applicant_id, $academic_yearIDQR) {
        $amountSubTotalPerAcDemic = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND (disbursement.status='8' OR disbursement.status='10') AND disbursement_batch.academic_year_id='$academic_yearIDQR' AND disbursement_batch.employer_id > '0' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_id ASC")->one();
        return $amountSubTotalPerAcDemic;
    }

    public static function getSubTotalAfterReturn($applicant_id, $academic_yearIDQR) {
        $subtotalOriginal = LoanBeneficiary::getAmountSubtotalPerAccademicY($applicant_id, $academic_yearIDQR);
        $returned = LoanBeneficiary::getAmountSubtotalReturned($applicant_id, $academic_yearIDQR);
        $amountsub = $subtotalOriginal->disbursed_amount - $returned->disbursed_amount;
        return $amountsub;
    }

    public static function getSubTotalAfterReturnThroughEmployer($applicant_id, $academic_yearIDQR) {
        $subtotalOriginal = LoanBeneficiary::getAmountSubtotalPerAccademicYThroughEmployer($applicant_id, $academic_yearIDQR);
        $returned = LoanBeneficiary::getAmountSubtotalReturnedThroughEmployer($applicant_id, $academic_yearIDQR);
        $amountsub = $subtotalOriginal->disbursed_amount - $returned->disbursed_amount;
        return $amountsub;
    }

    public static function getFooterInfosCustomerStatement() {
        return "telesphory";
    }

    public static function checkForReturnForLoanee($applicant_id) {
        $loanItemReturnedCheck = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.status='10' AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL GROUP BY disbursement.loan_item_id  ORDER BY disbursement.loan_item_id ASC")->all();
        if (count($loanItemReturnedCheck) > 0) {
            $results = 1;
        } else {
            $results = 0;
        }
        return $results;
    }

    public static function checkForBeneficiaryLoanNotThroughEmployer($applicant_id) {
        $loanItemReturnedCheck = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND (disbursement.status='8' OR disbursement.status='10') AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL GROUP BY disbursement.loan_item_id  ORDER BY disbursement.loan_item_id ASC")->count();
        if ($loanItemReturnedCheck > 0) {
            $results = 1;
        } else {
            $results = 0;
        }
        return $results;
    }

    public static function checkForBeneficiaryLoanThroughEmployer($applicant_id) {
        $loanItemReturnedCheck = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND (disbursement.status='8' OR disbursement.status='10') AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id > '0' GROUP BY disbursement.loan_item_id  ORDER BY disbursement.loan_item_id ASC")->count();
        if ($loanItemReturnedCheck > 0) {
            $results = 1;
        } else {
            $results = 0;
        }
        return $results;
    }

    public static function checkForReturnForLoaneeThroughEmployer($applicant_id) {
        $loanItemReturnedCheck = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.status='10' AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id > '0' GROUP BY disbursement.loan_item_id  ORDER BY disbursement.loan_item_id ASC")->all();
        if (count($loanItemReturnedCheck) > 0) {
            $results = 1;
        } else {
            $results = 0;
        }
        return $results;
    }

    public static function getAmountSubtotalPerAccademicYNoReturned($applicant_id, $academic_yearIDQR) {
        $allApplications = \common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $amountSubTotalPerAcDemicNoReturned = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.application_id FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE disbursement.status='8' AND disbursement_batch.academic_year_id='$academic_yearIDQR' AND disbursement.application_id IN($allApplications) AND  disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_id ASC")->one();
        return $amountSubTotalPerAcDemicNoReturned;
    }

    public static function getAmountSubtotalPerAccademicYNoReturnedGivenToApplicantThroughEmployer($applicant_id, $academic_yearIDQR) {
        $allApplications = \common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $amountSubTotalPerAcDemicNoReturned = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement_batch.employer_id AS 'employer_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE disbursement.status='8' AND disbursement_batch.academic_year_id='$academic_yearIDQR' AND disbursement.application_id IN($allApplications) AND  disbursement_batch.is_approved='1' AND disbursement_batch.employer_id > '0' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_id ASC")->one();
        return $amountSubTotalPerAcDemicNoReturned;
    }

    public static function getAmountPerAccademicYNoReturnedGivenToApplicantThroughEmployerCreateLoanSummary($employer_id) {
        //$allApplications=\common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $amountSubTotalPerAcDemicNoReturned = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement_batch.employer_id AS 'employer_id',application.applicant_id AS 'applicant_id',application.application_id AS 'application_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id  WHERE disbursement.status='8' AND disbursement_batch.employer_id='$employer_id' AND  disbursement_batch.is_approved='1' AND application.student_status<>'ONSTUDY' GROUP BY disbursement_batch.academic_year_id,disbursement.application_id ORDER BY disbursement.disbursement_id ASC")->all();
        return $amountSubTotalPerAcDemicNoReturned;
    }

    public static function getAcademicYear($applicant_id, $filter) {
        $academicYearTrend = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement_batch.employer_id IS NULL GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement_batch.academic_year_id $filter")->one();
        return $academicYearTrend;
    }

    public static function getTotalLoanNoReturn($applicant_id, $loanRepaymentItemRate) {
        $allApplications = \common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $totalLoanNoreturn = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM('$loanRepaymentItemRate'*disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id "
                        . "  WHERE disbursement.application_id IN($allApplications) AND disbursement.status='8' AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL")->one();
        return $totalLoanNoreturn;
    }

    public static function getTotalLoanNoReturnGivenThroughEmployer($applicant_id, $loanRepaymentItemRate) {
        $allApplications = \common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $totalLoanNoreturn = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM('$loanRepaymentItemRate'*disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id "
                        . "  WHERE disbursement.application_id IN($allApplications) AND disbursement.status='8' AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id >'0'")->one();
        return $totalLoanNoreturn;
    }

    public static function getPrincipleNoReturn($applicant_id) {
        $allApplications = \common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $principalNoreturn = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE disbursement.application_id IN($allApplications) AND disbursement.status='8' AND disbursement_batch.is_approved='1' AND disbursement.disbursed_as='1' AND disbursement_batch.employer_id IS NULL")->one();
        return $principalNoreturn;
    }

    public static function getPrinciplePlusReturn($applicant_id) {
        $principalPlusreturn = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND (disbursement.status='8' OR disbursement.status='10') AND disbursement_batch.employer_id IS NULL")->one();
        return $principalPlusreturn->disbursed_amount;
    }

    public static function getAmountReturned($applicant_id) {
        $amountSubTotalReturned = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND application.student_status<>'ONSTUDY' AND disbursement.status='10' AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL ORDER BY disbursement.disbursement_id ASC")->one();
        return $amountSubTotalReturned->disbursed_amount;
    }

    public static function getNewLoanSummaryAfterDeceasedBeneficiary($LoanSummaryID, $employerID) {
        $LoanSummaryModel = new \frontend\modules\repayment\models\LoanSummary();
        $LoanSummaryModel->ceaseBillIfEmployedBeneficiaryDisabled($LoanSummaryID, $employerID);
        $loan_given_to = \frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
        // start generating loan summary  getTotalLoanInBillAfterDecease
        //$totalAcculatedLoan = \backend\modules\repayment\models\EmployedBeneficiary::getTotalLoanInBillAfterDecease($employerID);
        $totalAcculatedLoan = 0;
        $resultsEmployer = \backend\modules\repayment\models\LoanSummary::getEmployerDetails($employerID);
        $billNumber = $resultsEmployer->employer_code . "-" . date("Y") . "-" . \backend\modules\repayment\models\LoanSummary::getLastBillID($employerID);
        $status = 0;
        $category = "Decease";
        $description = "";
        $created_by = Yii::$app->user->identity->user_id;
        $created_at = date("Y-m-d H:i:s");
        $vrf_accumulated = 0.00;
        $vrf_last_date_calculated = $created_at;
        \backend\modules\repayment\models\LoanSummary::insertNewValuesAfterTermination($employerID, $totalAcculatedLoan, $billNumber, $status, $description, $created_by, $created_at, $vrf_accumulated, $vrf_last_date_calculated);
        $New_loan_summary_id = \backend\modules\repayment\models\LoanSummary::getLastLoanSummaryID($employerID);
        //\backend\modules\repayment\models\LoanSummaryDetail::insertAllBeneficiariesUnderBillAfterDeceased($employerID, $New_loan_summary_id);
        \backend\modules\repayment\models\LoanSummaryDetail::insertAllBeneficiariesUnderBill($employerID, $New_loan_summary_id, $category);
        \backend\modules\repayment\models\LoanSummary::updateCeasedBill($employerID);
        $totalAmount = \backend\modules\repayment\models\LoanSummaryDetail::getTotalAmountForLoanSummary($New_loan_summary_id, $loan_given_to);
        \backend\modules\repayment\models\LoanSummary::updateNewTotalAmountLoanSummary($New_loan_summary_id, $totalAmount);
        //here end generate new loan summary
        return true;
    }

    public static function getAllApplicantApplications($applicantID) {
        $resultsAllocation = \frontend\modules\application\models\Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  applicant_id='{$applicantID}' AND student_status<>'ONSTUDY'")->asArray()->one();
        $valuesXcF = $resultsAllocation['application_id'];
        if ($valuesXcF != '') {
            $valuesXcF = $valuesXcF;
        } else {
            $valuesXcF = -1;
        }
        return $valuesXcF;
    }

    public static function getGraduationDate($applicantID, $application_id) {
        $results = \frontend\modules\application\models\Application::findBySql("SELECT date_graduated  FROM application WHERE  applicant_id='{$applicantID}' AND student_status<>'ONSTUDY' AND application.application_id='{$application_id}' ORDER BY application_id ASC")->asArray()->one();
        $valuesXcF = $results['date_graduated'];
        if ($valuesXcF != '') {
            $valuesXcF = $valuesXcF;
        } else {
            $valuesXcF = 0;
        }
        return $valuesXcF;
    }

    public static function getAllProgrammeStudied($applicant_id) {
        $allApplications = \common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $programmesResults = \frontend\modules\application\models\Application::findBySql("SELECT GROUP_CONCAT(DISTINCT(programme.programme_code)) as 'programme_name',GROUP_CONCAT(DISTINCT(learning_institution.institution_code)) as 'institution_code' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN application ON application.application_id=disbursement.application_id INNER JOIN programme ON programme.programme_id=disbursement.programme_id INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id"
                        . " WHERE disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id AND disbursement.application_id IN($allApplications) AND disbursement_batch.employer_id IS NULL AND  application.applicant_id=:applicant_id", [':applicant_id' => $applicant_id])->one();
        return $programmesResults;
    }

    public static function getAllProgrammeStudiedGeneral($applicant_id) {
        $allApplications = \common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $programmesResults = \frontend\modules\application\models\Application::findBySql("SELECT GROUP_CONCAT(DISTINCT(programme.programme_code)) as 'programme_name',GROUP_CONCAT(DISTINCT(learning_institution.institution_code)) as 'institution_code' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN application ON application.application_id=disbursement.application_id INNER JOIN programme ON programme.programme_id=disbursement.programme_id INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id"
                        . " WHERE disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id AND disbursement.application_id IN($allApplications)  AND  application.applicant_id=:applicant_id", [':applicant_id' => $applicant_id])->one();
        return $programmesResults;
    }

    public static function getAmountNoReturned($applicant_id) {
        $allApplications = \common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $amountNoReturned = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursed_amount, disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.status_date,academic_year.end_date,disbursement.application_id FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id AND disbursement.status='8' AND disbursement.application_id IN($allApplications) AND  disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL ORDER BY disbursement.disbursement_id ASC")->all();
        return $amountNoReturned;
    }

    public static function getVrFBeforeRepayment($disbusementDate) {
        //check bound
        $details_VRF = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT * FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id AND loan_repayment_item.item_code='VRF' AND loan_repayment_setting.is_active='1' AND (loan_repayment_setting.end_date IS NOT NULL OR loan_repayment_setting.end_date !='') AND loan_repayment_setting.formula_stage='1'")->all();
        //end check for bound
        if (count($details_VRF) > 0) {
            //get bound date
            $boundDate = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.end_date,loan_repayment_setting.loan_repayment_setting_id FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id AND loan_repayment_item.item_code='VRF' AND (loan_repayment_setting.end_date IS NOT NULL OR loan_repayment_setting.end_date !='') AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='1'")->one();
            $endDate = $boundDate->end_date;
            $Bound_loan_repayment_setting_id = $boundDate->loan_repayment_setting_id;
            //check bound end date formula_stage_level
            if ($endDate >= $disbusementDate) {
                $vrfApplicableFormula = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id',loan_repayment_setting.formula_stage_level,loan_repayment_setting.formula_stage_level_condition,loan_repayment_setting.grace_period  FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF' AND loan_repayment_setting.loan_repayment_setting_id='$Bound_loan_repayment_setting_id' AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='1'")->one();
            } else {
                $vrfApplicableFormula = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id',loan_repayment_setting.formula_stage_level,loan_repayment_setting.formula_stage_level_condition,loan_repayment_setting.grace_period  FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF' AND loan_repayment_setting.loan_repayment_setting_id<>'$Bound_loan_repayment_setting_id'  AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='1'")->one();
            }
            //end check bound end date formula_stage_level
        } else {
            $vrfApplicableFormula = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id',loan_repayment_setting.formula_stage_level,loan_repayment_setting.formula_stage_level_condition,loan_repayment_setting.grace_period  FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id AND loan_repayment_item.item_code='VRF' AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='1'")->one();
        }
        return $vrfApplicableFormula;
    }

    public static function getTotalLoanNoReturnPerApplication($application_id, $loanRepaymentItemRate) {
        $allApplications = \common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $totalLoanNoreturn = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM('$loanRepaymentItemRate'*disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id "
                        . "  WHERE disbursement.application_id ='$application_id' AND disbursement.status='8' AND disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL")->one();
        return $totalLoanNoreturn;
    }

    public static function getAmountNoReturnedperApplication($application_id) {
        //$allApplications=\common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
        $amountNoReturned = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursed_amount, disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.status_date,academic_year.end_date,disbursement.application_id FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id AND disbursement.status='8' AND disbursement.application_id='$application_id' AND  disbursement_batch.is_approved='1' AND disbursement_batch.employer_id IS NULL ORDER BY disbursement.disbursement_id ASC")->all();
        return $amountNoReturned;
    }

    static function getBeneficiaryLoanAllocationByApplicantID($id) {
        $query = \backend\modules\allocation\models\Allocation::find()
                ->select('allocation.allocation_batch_id,application_id,sum(allocated_amount) as allocated_amount,batch_number,batch_desc,created_at,allocation_batch.academic_year_id,')
                ->leftJoin('allocation_batch', 'allocation_batch.allocation_batch_id=allocation.allocation_batch_id')
                ->where('allocation.application_id IN (SELECT application_id from application  WHERE application.applicant_id=:applicant_id) AND allocation.is_canceled=0', [':applicant_id' => $id])
                ->orderBy('allocation_batch.created_at ASC')
                ->groupBy('allocation.allocation_batch_id');
        return new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
    }

    static function getLiqudationStatusNameByApplicantID($applicant_id) {
        $data = self::find()->where(['applicant_id' => $applicant_id])->one();
        if ($data) {
            switch ($data->liquidation_letter_status) {

                case self::LOAN_LIQUIDATION_NOT_ISSUED:
                    return 'Not issued';
                    break;

                case self::LOAN_LIQUIDATION_ISSUED;
                    return 'Issued/send to Beneficiary';
                    break;
            }
        }
        return NULL;
    }

    static function getLiqudationStatusByApplicantID($applicant_id) {
        $data = self::find()->where(['applicant_id' => $applicant_id])->one();
        if ($data) {
            return $data->liquidation_letter_status;
        }
        return NULL;
    }

    static function getLoanConfirmationStatusByApplicantID($applicant_id) {
        $data = self::find()->where(['applicant_id' => $applicant_id])->one();
        if ($data) {
            return $data->loan_confirmation_status;
        }
        return NULL;
    }

    static function getLoanConfirmationStatusNameByApplicantID($applicant_id) {
        $data = self::find()->where(['applicant_id' => $applicant_id])->one();
        if ($data) {
            switch ($data->loan_confirmation_status) {

                case self::LOAN_STATEMENT_NOT_CONFIRMED:
                    return 'Not Confirmed';
                    break;

                case self::LOAN_STATEMENT_CONFIRMED;
                    return 'Confirmed';
                    break;
            }
        }
        return NULL;
    }
public static function getLoanRepaymentSchedule($applicant_id){

ini_set('memory_limit', '10000M');
set_time_limit(0);
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;

$subtitalAcc=0;
$subtitalAccq=0;
$date=date("Y-m-d");
$duration_type="months";
?>
 <?php 
$loanee = \frontend\modules\application\models\Applicant::find()
	                                                           ->where(['applicant_id'=>$applicant_id])->one();
$getProgramme = \frontend\modules\application\models\Application::findBySql("SELECT applicant.sex,applicant.f4indexno,programme.programme_name,learning_institution.institution_code FROM application INNER JOIN applicant ON applicant.applicant_id=application.applicant_id INNER JOIN disbursement ON disbursement.application_id=application.application_id INNER JOIN programme ON programme.programme_id=disbursement.programme_id INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id WHERE application.applicant_id=:applicant_id",[':applicant_id'=>$applicant_id])->one();

$programmeResultd=\common\models\LoanBeneficiary::getAllProgrammeStudiedGeneral($applicant_id);

$balance=\frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($applicant_id,$date,$loan_given_to);

$getPaymentsOfLoanee = \backend\modules\repayment\models\LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount,loan_repayment.payment_date,employer.employer_code,employer.short_name,loan_repayment_detail.applicant_id FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id LEFT JOIN employer ON employer.employer_id=loan_repayment.employer_id LEFT JOIN applicant ON applicant.applicant_id=loan_repayment.applicant_id WHERE loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id AND loan_repayment_detail.loan_given_to='$loan_given_to' AND loan_repayment.payment_status='1' AND loan_repayment_detail.applicant_id=:applicant_id GROUP BY loan_repayment.payment_date ORDER BY loan_repayment.payment_date ASC",[':applicant_id'=>$applicant_id])->all();
$sno=1;

$amountPTotal=0;
$amountPTotalAccumulated=0;
$totalLAFLoop=0;
$totalPNTLoop=0;
$totalVRFLoop=0;
$totalPRCLoop=0;
$totalPrinciplePaid=0;
$totalAcruedVRF=0;
$totalAcruedVRFfirst=0;
$totalAcruedVRF1First=0;
$acruedVRFBefore=0;
$amountPerMonth=0;

$TotalamountPerMonth =0;
$amountPerMonthLAF =0;
$amountPerMonthPNT =0;
$amountPerMonthVRF =0;
$amountPerMonthPRC =0;
$totalAcruedVRF =0;
$TotalPRCGeneral =0;

$factor=2;//the possible payment loop
//check if employed
     $MLREB=\frontend\modules\repayment\models\EmployedBeneficiary::getEmployedBeneficiaryPaymentSetting();	
	 $paymentCalculation = \frontend\modules\repayment\models\EmployedBeneficiary::findBySql("SELECT  basic_salary,applicant_id  FROM employed_beneficiary WHERE  employed_beneficiary.applicant_id='$applicant_id' AND employment_status='ONPOST' AND verification_status='1' AND loan_summary_id >'0'")->one();
	 if($paymentCalculation->applicant_id > 0){
	$amount1=$MLREB*$paymentCalculation->basic_salary;	 
	 }else{
	$amount1=\frontend\modules\repayment\models\EmployedBeneficiary::getNonEmployedBeneficiaryPaymentSetting();
	 }	 
//end check if employed

//check the last payment of beneficiary
$paymentLoanRepayment = \frontend\modules\repayment\models\LoanRepaymentDetail::findBySql("SELECT  loan_repayment.payment_date  FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id WHERE  loan_repayment_detail.applicant_id='$applicant_id' AND loan_repayment.payment_status='1' AND loan_repayment_detail.loan_given_to='$loan_given_to'")->orderBy(['loan_repayment_detail'=>SORT_DESC])->one();
$lastPaydate = date_create($paymentLoanRepayment->payment_date);
$todate = date_create($date);
$interval = date_diff($lastPaydate, $todate);
$dateDifferenceInMonth=$interval->format('%m');

if($paymentLoanRepayment->payment_date !=''){
	if($dateDifferenceInMonth > 0){
$payment_date=date("Y-m-d");
	}else{
				$payment_date=$paymentLoanRepayment->payment_date;
	}
}else{
$payment_date=date("Y-m-d");	
}
//end last payment

//get total intervals of payment
$totalMonths=$balance/$amount1;
//end get total intervals of payment
        $totalAmount=0; 
        $constantPaymentDate=date("Y-m-d",strtotime($payment_date));
		
//check ORIGINAL AMOUNT PER Items
$totalPrincipalORGN=\backend\modules\repayment\models\LoanSummaryDetail::getTotalPrincipleLoanOriginal($applicant_id,$date,$loan_given_to);
$totalVRFORGN=\backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($applicant_id,$date,$loan_given_to);
$totalPNTORGN=\backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($applicant_id,$date,$loan_given_to);
$totalLAFORGN=\backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($applicant_id,$date,$loan_given_to);
//end check amount per item		
//check loan repayment item balances
//-------------Items ID------
    $itemCodeLAF="LAF";
	$LAF_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeLAF);
	$itemCodePNT="PNT";
	$PNT_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePNT);
	$itemCodeVRF="VRF";
	$VRF_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeVRF);
	$itemCodePRC="PRC";
	$PRC_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePRC);
//------------end items ID------------

    $AmountPaidPerItemTotalLAF=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id,$LAF_id,$loan_given_to);
	$totalAmountAlreadyPaidLAF=$AmountPaidPerItemTotalLAF->amount;
	$AmountPaidPerItemTotalPNT=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id,$PNT_id,$loan_given_to);
	$totalAmountAlreadyPaidPNT=$AmountPaidPerItemTotalPNT->amount;
	$AmountPaidPerItemTotalVRF=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id,$VRF_id,$loan_given_to);
	$totalAmountAlreadyPaidVRF=$AmountPaidPerItemTotalVRF->amount;
	$AmountPaidPerItemTotalPRC=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id,$PRC_id,$loan_given_to);
	$totalAmountAlreadyPaidPRC=$AmountPaidPerItemTotalPRC->amount;
	$balanceLAF=$totalLAFORGN-$totalAmountAlreadyPaidLAF;
	$balancePNT=$totalPNTORGN-$totalAmountAlreadyPaidPNT;
	$balanceVRF=$totalVRFORGN-$totalAmountAlreadyPaidVRF;
	$balancePRC=$totalPrincipalORGN-$totalAmountAlreadyPaidPRC;
	if($balanceLAF > 0){$balanceLAF=$balanceLAF;$balanceLAFfirst=$balanceLAF;}else{$balanceLAF=0;$balanceLAFfirst=0;}
	if($balancePNT > 0){$balancePNT=$balancePNT;$balancePNTFirst=$balancePNT;}else{$balancePNT=0;$balancePNTFirst=0;}
	if($balanceVRF > 0){$balanceVRF=$balanceVRF;$balanceVRFfirst=$balanceVRF;}else{$balanceVRF=0;$balanceVRFfirst=0;}
	if($balancePRC > 0){$balancePRC=$balancePRC;$balancePRCFirst=$balancePRC;}else{$balancePRC=0;$balancePRCFirst=0;}
	$resultsVRFRepaymentRate=\backend\modules\repayment\models\LoanRepaymentSetting::getLoanRepaymentRateVRF($VRF_id);
	$vrfRepaymentRate=$resultsVRFRepaymentRate->loan_repayment_rate*0.01;
	$resultsLAFRepaymentRate=\backend\modules\repayment\models\LoanRepaymentSetting::getLoanRepaymentRateOtherItems($LAF_id);
	$LAFRepaymentRate=$resultsLAFRepaymentRate->loan_repayment_rate*0.01;
	$resultsPNTRepaymentRate=\backend\modules\repayment\models\LoanRepaymentSetting::getLoanRepaymentRateOtherItems($PNT_id);
	$PNTRepaymentRate=$resultsPNTRepaymentRate->loan_repayment_rate*0.01;
	$numberOfDaysPerYear=\backend\modules\repayment\models\EmployedBeneficiary::getTotaDaysPerYearSetting();
//end  check loan repayment item balances       
//get VRF before schedule
			    $dateConstantForPaymentbe=$constantPaymentDate;
				$dateCreatedqqbe=date_create($dateConstantForPaymentbe);
				$dateDurationAndTypeqqbe="1"." ".$duration_type;
				date_add($dateCreatedqqbe,date_interval_create_from_date_string($dateDurationAndTypeqqbe));
				$payment_dateBe=date_format($dateCreatedqqbe,"Y-m-d");
				$totalNumberOfDaysBe=round((strtotime($payment_dateBe)-strtotime($date))/(60*60*24));
				$acruedVRFBefore=$balancePRC*$vrfRepaymentRate*$totalNumberOfDaysBe/$numberOfDaysPerYear;
//end get VRF before schedule        		
        //foreach ($details_applicant as $paymentCalculation) { 			   
           $totalOutstandingAmount=$balance;
		   if($totalOutstandingAmount > 0){
			$countForPaymentDate=1;
			$countForPaymentDateFirst=1;
			$countForPaymentDate1First=1;
			
			$totalMonths=((($balancePRC + $balanceLAF + $balancePNT + $balanceVRF)/$amount1)*$factor);
			$totalOutstandingAmount=($balancePRC + $balanceLAF + $balancePNT + $balanceVRF);
			$balanceVRF +=$acruedVRFBefore;
        for($countP=1;$countP <= $totalMonths; ++$countP){
			$amountPTotal +=$amount1;
			//if($totalOutstandingAmount >= $amountPTotal){
				if(($balanceVRF >=$overallVRFinPayment) OR ($balancePRC >= $totalPrinciplePaid)){
			//get payment date
			    $dateConstantForPayment=$constantPaymentDate;
				$dateCreatedqq=date_create($dateConstantForPayment);
				$dateDurationAndTypeqq=$countForPaymentDate." ".$duration_type;
				date_add($dateCreatedqq,date_interval_create_from_date_string($dateDurationAndTypeqq));
				$payment_date=date_format($dateCreatedqq,"Y-m-d");
				//end	
			$amountPTotalAccumulated=$amountPTotal;
			$payment_dateLast=$payment_date;
			$mnc=0;
			//distribute amount in respective item according to the repayment rate
			//----here for LAF portion----
			if($balanceLAF > 0){
				if($amount1 >=$balanceLAF ){
				$LAFportion=$balanceLAF;
                $remainingAmount=$amount1-$balanceLAF;			
				}else{
				$LAFportion=$amount1;
                $remainingAmount=0;				
				}
			}else{
			$remainingAmount=$amount1;	
			}
			
			$totalLAFPaymentTotal=$totalLAFLoop;
			$totalLAFLoop +=$LAFportion;
			if($balanceLAF >= $totalLAFLoop){$LAFportion=$LAFportion;}else{
				$LAFportion1=$balanceLAF - $totalLAFPaymentTotal;
				if($LAFportion1 > 0){
				$LAFportion=$LAFportion1;	
				}else{
					$LAFportion=0;
				}
				}
			
			$amount_remained=$amount1-$LAFportion;
			
			//----here for penalty portion----	
         $penalty_portion = $amount_remained * $PNTRepaymentRate;
            if(($balancePNT >= $penalty_portion) && $balancePNT > 0){
             $penalty_portion=$penalty_portion;   
            }else if((($balancePNT < $penalty_portion) && $balancePNT > 0)){
             $penalty_portion=$balancePNT;   
            }else{
             $penalty_portion=0;   
            }
		 
			$totalPNTPaymentTotal=$totalPNTLoop;
			$totalPNTLoop +=$penalty_portion;
			if($balancePNT >= $totalPNTLoop){$penalty_portion=$penalty_portion;}else{
				$penalty_portion1=$balancePNT - $totalPNTPaymentTotal;
				if($penalty_portion1 > 0){
				$penalty_portion=$penalty_portion1;	
				}else{
					$penalty_portion=0;
				}
				}
		$amount_remained1=$amount_remained-$penalty_portion;		
        //---end for penalty----
		$totalPRCPaymentTotal=$totalPRCLoop;
		$principleBalancePreviousFirst=$balancePRC-$totalPRCPaymentTotal;
		//here VRF ACRUE 
			if($countP > 1){
				
			    $dateConstantForPayment1First=$constantPaymentDate;
				$dateCreatedqq1First=date_create($dateConstantForPayment1First);
				$dateDurationAndTypeqqFirst=$countForPaymentDate1First." ".$duration_type;
				date_add($dateCreatedqq1First,date_interval_create_from_date_string($dateDurationAndTypeqqFirst));
				$payment_date1First=date_format($dateCreatedqq1First,"Y-m-d");	
			$totalNumberOfDaysFirst=round((strtotime($payment_date)-strtotime($payment_date1First))/(60*60*24));
			if($principleBalancePreviousFirst > 0){
			$totalAcruedVRF1First=$principleBalancePreviousFirst*$vrfRepaymentRate*$totalNumberOfDaysFirst/$numberOfDaysPerYear;
			}else{
			$totalAcruedVRF1First=0;	
			}
            //$totalAcruedVRFFirst .=$totalAcruedVRF1First."----".$principleBalancePreviousFirst."---".$payment_date1First."--".$payment_dateFirst."--".$totalNumberOfDaysFirst."<br/>";
            //$totalAcruedVRFfirst +=$totalAcruedVRF1First;			
			++$countForPaymentDate1First;
			//echo  $totalNumberOfDaysFirst."tele";exit;
			}			
			$balanceVRF +=$totalAcruedVRF1First;
			//END VRF ACRUE		    
		
		//-----here for VRF portion----
		
        if($balancePRC > 0){
         $vrf_portion=$amount_remained1 * $vrfRepaymentRate;		 
         if($balanceVRF >=$totalVRFLoop){
			 if($balanceVRF >=$vrf_portion){
         $vrfTopay=$vrf_portion;
         $amount_remained22=$amount_remained1-$vrfTopay;		 
		 }else{
         $vrfTopay=$balanceVRF; 
         $amount_remained22=$amount_remained1-$vrfTopay;
		 }         
         }else{
         $vrfTopay=0; 
         $amount_remained22=$amount_remained1-$vrfTopay;
         }         
        }else{
            if($balanceVRF >=$amount_remained1){
         $vrfTopay=$amount_remained1;
         $amount_remained22=0; 
         }else{
         $vrfTopay=$balanceVRF; 
         $amount_remained22=0;
         }
        }
	
		$totalVRFPaymentTotal=$totalVRFLoop;

	        
			if($balanceVRF >= $totalVRFLoop){
				if($balanceVRF >=($totalVRFLoop + $vrfTopay)){
				$vrfTopay=$vrfTopay;
			}else{$vrfTopay=$vrfTopay-(($totalVRFLoop + $vrfTopay)-$balanceVRF);}}else{
				$vrfTopay1=$balanceVRF - $totalVRFPaymentTotal;
				if($vrfTopay1 > 0){
				$vrfTopay=$vrfTopay1;	
				}else{
					$vrfTopay=0;
				}
				}
				$totalVRFLoop +=$vrfTopay; 
					
				
		$amount_remained2=$amount_remained1-$vrfTopay;		
		//end here for VRF portion----
		
		//check if principal amount exceed
        if($balancePRC >= $amount_remained2){
        $amount_remained2=$amount_remained2;    
        }else if($balancePRC < $amount_remained2 && $balancePRC >'0'){
        $amount_remained2=$balancePRC;    
        }else{
        $amount_remained2='0';    
        }
		
			$totalPRCLoop +=$amount_remained2;
			
			if($balancePRC >= $totalPRCLoop){$amount_remained2=$amount_remained2;}else{
				$amount_remained211=$balancePRC - $totalPRCPaymentTotal;
				if($amount_remained211 > 0){
				//$amount_remained2=$amount_remained211;
                $amount_remained2=$amount_remained2;				
				}else{
					$amount_remained2=0;
				}
				}	
        // end check principle amount exceed
			//end
			//first check principalbalance and incoming balance
			$principleBalance=$balancePRC-$totalPrinciplePaid;
			if($principleBalance > $amount_remained2){
				$amount_remained2=$amount_remained2;
			}else{
				$amount_remained2=$principleBalance;
			}
            //end check			
			
			$totalPrinciplePaid +=$amount_remained2;
			$principleBalance=$balancePRC-$totalPrinciplePaid;
			if($principleBalance > 0){
				$principleBalance=$principleBalance;
			}else{
			$principleBalance=0;	
			}
			
			
			$overallLAFinPayment +=$LAFportion;
			$overallPNTinPayment +=$penalty_portion;
			$overallVRFinPayment +=$vrfTopay;
            if($countP==1){
				$totalAcruedVRF1First=$acruedVRFBefore + $balanceVRFfirst;
			}else{
			$totalAcruedVRF1First=$totalAcruedVRF1First;	
			}
			$vrfTopayCheckIf=number_format($vrfTopay,2);$checkLAFportionIf=number_format($LAFportion,2);$checkpenalty_portionIf=number_format($penalty_portion,2);$checkamount_remained2If=number_format($amount_remained2,2);$checktotalAcruedVRF1FirstIf=number_format(($totalAcruedVRF1First),2);$checkprincipleBalanceIf=number_format(($principleBalance),2);
if($checkLAFportionIf > 0 || $checkpenalty_portionIf > 0 || $vrfTopayCheckIf > 0 || $checkamount_remained2If > 0 || $checktotalAcruedVRF1FirstIf > 0 || $checkprincipleBalanceIf > 0){
            $lastPaymentDate=date("Y-m-d",strtotime($payment_date));	
            $amount1=$LAFportion + $penalty_portion + $vrfTopay + $amount_remained2;
			if($countP == 1){
			$schedule_start_date=date("Y-m-d",strtotime($payment_date));
            $monthly_installment=$amount1;			
			}
			$TotalamountPerMonth +=$amount1;
			$amountPerMonthLAF +=$LAFportion;
			$amountPerMonthPNT +=$penalty_portion;
			$amountPerMonthVRF +=$vrfTopay;
			$amountPerMonthPRC +=$amount_remained2;
			$totalAcruedVRF +=$totalAcruedVRF1First;
			$TotalPRCGeneral +=$principleBalance;
}
			}
			//echo  $totalAcruedVRF1First;exit;
			++$countForPaymentDate;
		}
		}

//return "Total Amount to be paid=".number_format($TotalamountPerMonth,2)."<br/>"."Laf Portion=".number_format($amountPerMonthLAF,2)."<br>"."Penalty Portion".number_format($amountPerMonthPNT,2)."<br>"."Vrf Portion".number_format($amountPerMonthVRF,2)."<br/>"."Principal Portion".number_format($amountPerMonthPRC,2)."<br/>"."Last Payment Date is: ".$lastPaymentDate;	
$schedule_principal_amount=$amountPerMonthPRC;
$schedule_penalty=$amountPerMonthPNT;
$schedule_laf=$amountPerMonthLAF;
$schedule_vrf=$amountPerMonthVRF;
$schedule_total_loan_amount=$TotalamountPerMonth;
$schedule_start_date=$schedule_start_date;
$monthly_installment=$monthly_installment;
$created_at=date("Y-m-d H:i:s");
$lastPaymentDate=$lastPaymentDate;
//check exists in loan beneficiary table
if(self::find()->where(['applicant_id'=>$applicant_id])->count()==0){
 Yii::$app->db->createCommand("INSERT IGNORE INTO  loan_beneficiary(applicant_id,created_at,updated_at) VALUES('$applicant_id','$created_at','$created_at')")->execute();	
}
self::updateAll(['schedule_principal_amount' => $schedule_principal_amount,'schedule_penalty'=>$schedule_penalty,'schedule_laf'=>$schedule_laf,'schedule_vrf'=>$schedule_vrf,'schedule_total_loan_amount'=>$schedule_total_loan_amount,'schedule_start_date'=>$schedule_start_date,'schedule_end_date'=>$lastPaymentDate,'monthly_installment'=>$monthly_installment], 'applicant_id ="' . $applicant_id . '"');	

//end check

	}
	public static function getScheduleDetail($applicantID) {
        return self::findBySql("SELECT schedule_principal_amount,schedule_penalty,schedule_laf,schedule_vrf,schedule_total_loan_amount,schedule_start_date,schedule_end_date,monthly_installment FROM loan_beneficiary WHERE  applicant_id='{$applicantID}'")->one();
    }

}
