<?php

namespace backend\modules\disbursement\models;

use Yii;
use \kop\y2cv\ConditionalValidator;

/**
 * This is the model class for table "disbursement_batch".
 *
 * @property integer $disbursement_batch_id
 * @property integer $allocation_batch_id
 * @property integer $learning_institution_id
 * @property integer $academic_year_id
 * @property integer $financial_year_id
 * @property integer $instalment_definition_id
 * @property integer $loan_item_id
 * @property integer $batch_number
 * @property string $batch_desc
 * @property integer $instalment_type
 * @property integer $version
 * @property integer $is_approved
 * @property string $approval_comment
 * @property integer $institution_payment_request_id
 * @property string $payment_voucher_number
 * @property string $cheque_number
 * @property integer $disburse
 * @property integer $disbursed_as
 * @property integer $country
 * @property integer $applicant_category
 * @property integer $level
 * @property integer $disburse_type
 * @property string $created_at
 * @property integer $created_by
 *
 * @property Disbursement[] $disbursements
 * @property AcademicYear $academicYear
 * @property AllocationBatch $allocationBatch
 * @property InstalmentDefinition $instalmentDefinition
 * @property InstitutionPaymentRequest $institutionPaymentRequest
 * @property LearningInstitution $learningInstitution
 * @property User $createdBy
 * @property LoanItem $loanItem
 */
class DisbursementBatch extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    // const STATUS_DELETED = 0;
    const APPLOCANT_CATEGORY = 2;

    public static function tableName() {
        return 'disbursement_batch';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['academic_year_id', 'financial_year_id', 'instalment_definition_id','disburse', 'disbursed_as', 'applicant_category'], 'required'],
            [['allocation_batch_id', 'learning_institution_id', 'academic_year_id', 'financial_year_id', 'instalment_definition_id', 'loan_item_id', 'batch_number', 'instalment_type', 'version', 'is_approved', 'institution_payment_request_id', 'disburse', 'disbursed_as','applicant_category', 'level', 'disburse_type', 'created_by'], 'integer'],
            [['approval_comment'], 'string'],
            [['allocation_batch_id','file'], 'safe'],
            ['country', 'required', 'when' => function ($model) {
                    return $model->applicant_category ==2;
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#disbursementbatch-applicant_category').val() == '2'; }"],
            ['learning_institution_id', 'required', 'when' => function ($model) {
                    return $model->level == 1;
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#disbursementbatch-level').val() == '1'; }"],
            ['file', 'required', 'when' => function ($model) {
                    return $model->disburse == 2;
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#disbursementbatch-disburse').val() == '2'; }"],
             ['employer_id', 'required', 'when' => function ($model) {
                    return $model->level == 2;
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#disbursementbatch-level').val() == '2'; }"],
            ['version', 'required', 'when' => function ($model) {
                    return $model->instalment_type== 2;
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#disbursementbatch-instalment_type').val() == '2'; }"],
            [['batch_number', 'created_at', 'file', 'employer_id', 'created_at', 'loan_item_id', 'created_by','instalment_type'], 'safe'],
            [['batch_desc'], 'string', 'max' => 100],
            [['payment_voucher_number', 'cheque_number'], 'string', 'max' => 45],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['allocation_batch_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\AllocationBatch::className(), 'targetAttribute' => ['allocation_batch_id' => 'allocation_batch_id']],
            [['instalment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstalmentDefinition::className(), 'targetAttribute' => ['instalment_definition_id' => 'instalment_definition_id']],
            [['institution_payment_request_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstitutionPaymentRequest::className(), 'targetAttribute' => ['institution_payment_request_id' => 'institution_payment_request_id']],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\LoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'disbursement_batch_id' => 'Disbursement Batch',
            'allocation_batch_id' => 'Allocation Batch',
            'learning_institution_id' => 'Learning Institution',
            'academic_year_id' => 'Academic Year',
            'financial_year_id' => 'Financial Year ',
             'employer_id' => 'Employee Name ',
            'instalment_definition_id' => 'Instalment Definition',
            'loan_item_id' => 'Loan Item ',
            'batch_number' => 'Batch Number',
            'batch_desc' => 'Batch Desc',
            'instalment_type' => 'Instalment Type',
            'version' => 'Version',
            'is_approved' => 'Is Approved',
            'approval_comment' => 'Approval Comment',
            'institution_payment_request_id' => 'Institution Payment Request',
            'payment_voucher_number' => 'Payment Voucher Number',
            'cheque_number' => 'Cheque Number',
            'disburse' => 'Disburse',
            'disbursed_as' => 'Disbursed As',
            'country' => 'Country',
            'applicant_category' => 'Applicant Category',
            'level' => 'Level',
            'disburse_type' => 'Disburse Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'file' => 'Select Pay List',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursements() {
        return $this->hasMany(DisbursementBatch::className(), ['disbursement_batch_id' => 'disbursement_batch_id']);
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
    public function getAllocationBatch() {
        return $this->hasOne(\backend\modules\allocation\models\AllocationBatch::className(), ['allocation_batch_id' => 'allocation_batch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstalmentDefinition() {
        return $this->hasOne(InstalmentDefinition::className(), ['instalment_definition_id' => 'instalment_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionPaymentRequest() {
        return $this->hasOne(InstitutionPaymentRequest::className(), ['institution_payment_request_id' => 'institution_payment_request_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution() {
        return $this->hasOne(\backend\modules\application\models\LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }
    
    public function getSemester()
    {
        return $this->hasOne(\common\models\Semester::className(), ['semester_number' => 'semester_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem() {
        return $this->hasOne(\backend\modules\allocation\models\LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }

    public function getStudents($instituteId, $applicant_category,$academic_year,$loan_item,$instalmentId){
 
        return Yii::$app->db->createCommand("SELECT *,((`allocated_amount`*`percentage`)/100) as amount FROM disbursement_view dv join applicant ap  
                                                 on ap.applicant_id=dv.applicant_id 
                                                 join disbursement_setting ds 
                                                 on dv.`loan_item_id`=ds.`loan_item_id`
                                                AND dv.`academic_year_id`=ds.`academic_year_id`
                                                AND applicant_category_id='{$applicant_category}'
                                                AND dv.academic_year_id='{$academic_year}'
                                                AND ds.instalment_definition_id='{$instalmentId}'
                                                AND dv.loan_item_id IN($loan_item)
                                                AND dv.learning_institution_id='{$instituteId}'")->queryAll();
    }
    public function getStudentselective($instituteId, $applicant_category, $academic_year, $loan_item,$instalmentId,$selectivedata) {
 
     
        return Yii::$app->db->createCommand("SELECT *,((`allocated_amount`*`percentage`)/100) as amount FROM disbursement_view dv join applicant ap  
                                                 on ap.applicant_id=dv.applicant_id 
                                                 join disbursement_setting ds 
                                                 on dv.`loan_item_id`=ds.`loan_item_id`
                                                AND dv.`academic_year_id`=ds.`academic_year_id`
                                                AND applicant_category_id='{$applicant_category}'
                                                AND dv.academic_year_id='{$academic_year}'
                                                AND ds.instalment_definition_id='{$instalmentId}'
                                                AND f4indexno IN('$selectivedata')
                                                AND dv.loan_item_id IN($loan_item)
                                                AND dv.learning_institution_id='{$instituteId}'")->queryAll();
    }
   public function getDisbursementstatus($instituteId, $academic_year, $loan_item,$applicationId,$version,$instalment) {
    
       return Yii::$app->db->createCommand("SELECT * FROM disbursement ds,programme p,disbursement_batch db 
                                                      WHERE ds.programme_id=p.programme_id 
                                                      AND db.`disbursement_batch_id`=ds.`disbursement_batch_id` 
                                                      AND p.`learning_institution_id`=db.`learning_institution_id` 
                                                      AND p.`learning_institution_id`='{$instituteId}'
                                                      AND db.academic_year_id='{$academic_year}'
                                                      AND application_id='{$applicationId}'
                                                      AND ds.loan_item_id='{$loan_item}'
                                                      AND db.instalment_definition_id='{$instalment}'
                                                      AND ds.version='{$version}'
                                                      ")->queryAll();
    }
}
