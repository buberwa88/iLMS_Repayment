<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\Application;
use \frontend\modules\application\models\ApplicantAttachment;

/**
 * ApplicationSearch represents the model behind the search form about `backend\modules\application\models\Application`.
 */
class ApplicationSearch extends Application
{
    /**
     * @inheritdoc
     */
        public  $instititution;
        public $firstName;
        public $surname;
        public $f4indexno;
        //added tele
        public $middlename;
        public $sex;
        public $applicant_category;
        public $date_verified2;
        public $officer;
        public $assigned_at2;
        public $verification_status1;
        public $verification_comment;
        public $comment;
        public $assignee_asi;
        public $assignee3;
		public $attachment_status;
        //end
    public function rules()
    {
        return [
            [['application_id', 'applicant_id', 'academic_year_id', 'programme_id', 'application_study_year', 'current_study_year', 'applicant_category_id', 'bank_id', 'submitted', 'verification_status', 'allocation_status'], 'integer'],
            [['bill_number','firstName','surname','f4indexno','control_number','registration_number', 'receipt_number', 'pay_phone_number', 'date_bill_generated', 'date_control_received', 'date_receipt_received', 'bank_account_number', 'bank_account_name', 'bank_branch_name', 'allocation_comment', 'student_status', 'created_at','instititution','middlename','assignee','middlename','sex','applicant_category','date_verified','date_verified2','assignee','officer','assigned_at2','assigned_at','sex','verification_status1','verification_comment','comment','verification_framework_id','assignee_asi','assignee3','attachment_status','application_form_number'], 'safe'],
            [['amount_paid', 'needness'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$condition)
    {
        $loggedin = Yii::$app->user->identity->user_id;
        $query = Application::find()
                              ->where(['application.verification_status'=>$condition,'application.loan_application_form_status'=>3,'assignee'=>$loggedin]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        //$query->joinWith("educations");
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])    
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            //->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        //$query->where($condition);

        return $dataProvider;
    }
    public function searchcompliance($params)
    {
        $query = Application::find();
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->joinWith("programme");
        $query->joinWith("programme.learningInstitution");
         $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status]);

        return $dataProvider;
    }
    public function searchbankall($params)
    {
        $query = Application::find()
                      ->orWhere(['IS','application.bank_account_number', null])
                      ->orWhere(['IS','application.registration_number', null]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->joinWith("programme");
        $query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
        ]);
$query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->orFilterWhere(['=', 'bank_account_number', $this->bank_account_number==1?null:$this->bank_account_number])
            ->orFilterWhere(['=', 'registration_number', $this->registration_number==1?null:$this->registration_number])     
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.surname', $this->lastName])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);
        return $dataProvider;
    }
    public function searchMeanTest($params)
    {
        $query = Application::find()->where(['allocation_status'=>1]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>FALSE
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->joinWith("programme");
        $query->joinWith("programme.learningInstitution");
         $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'student_status', $this->student_status]);

        return $dataProvider;
    }
         public function searchComputeNeedness($params)
    {
        $query = Application::find()->where(['allocation_status'=>5]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>FALSE
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->joinWith("programme");
        $query->joinWith("programme.learningInstitution");
         $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'student_status', $this->student_status]);

        return $dataProvider;
    }
        public function searchawardloan($params)
    {
        $query = Application::find()->where(['allocation_status'=>6]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>FALSE
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->joinWith("programme");
        $query->joinWith("programme.learningInstitution");
         $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
        ]);
  $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'student_status', $this->student_status]);

        return $dataProvider;
    }
    public function searchbank($params)
    {
        $query = Application::find()
                      ->orWhere(['IS','application.bank_account_number', null])
                      ->orWhere(['IS','application.registration_number', null]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->joinWith("programme");
        $query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
        ]);
        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->orFilterWhere(['=', 'bank_account_number', $this->bank_account_number==1?null:$this->bank_account_number])
            ->orFilterWhere(['=', 'registration_number', $this->registration_number==1?null:$this->registration_number])     
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);
        return $dataProvider;
    }
    public function searchVerificationAssigned($params)
    {
        $query = Application::find()
                              ->andWhere(['application.verification_status'=>[0,1,2,3,4,5]])
                              ->andWhere(['not',
                                  ['application.assignee'=>NULL],
                                  ])
                               ->andWhere(['not',
                                  ['application.assignee'=>''],
                                  ]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        //$query->joinWith("educations");
        $query->joinWith("educations")->groupBy(['education.application_id']);
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'assignee' => $this->assignee,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,	                
            'assignee' => $this->assignee3,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'assignee' => $this->assignee_asi,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])    
            ->andFilterWhere(['like', 'user.surname', $this->surname])
	    //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            //->andFilterWhere(['like', 'education.registration_number', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])    
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        //$query->where($condition);

        return $dataProvider;
    }
	public function searchAllSubmitedApplications($params)
    {
        $loggedin = Yii::$app->user->identity->user_id;
        $query = Application::find()
                              ->where(['application.loan_application_form_status'=>3]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        $query->joinWith("applicantAttachments")->groupBy(['applicant_attachment.application_id']);
        $query->joinWith("educations")->groupBy(['education.application_id']);
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        //$query->leftJoin('applicant_attachment', 'applicant_attachment.application_id=application.application_id');
        $query->joinWith("academicYear");
        $query->joinWith("verificationFramework");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->officer,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'application.assignee'=>$this->assignee,
            'application.verification_framework_id'=>$this->verification_framework_id,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])                                   
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])    
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        if($this->date_verified !='' && $this->date_verified2 !=''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified !='' && $this->date_verified2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified =='' && $this->date_verified2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }
        
        if($this->assigned_at !='' && $this->assigned_at2 !=''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }else if($this->assigned_at !='' && $this->assigned_at2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->assigned_at." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->assigned_at =='' && $this->assigned_at2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->assigned_at2." 23:59:59"]);
        }
        

        return $dataProvider;
    }
    public function searchVerificationReport($params,$condition)
    {
        $loggedin = Yii::$app->user->identity->user_id;
        $query = Application::find()
                              ->where(['application.verification_status'=>$condition,'application.loan_application_form_status'=>3]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        //$query->joinWith("educations");
        $query->joinWith("applicantAttachments")->groupBy(['applicant_attachment.application_id']);
        $query->joinWith("educations")->groupBy(['education.application_id']);
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->officer,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'application.assignee'=>$this->assignee,
			'applicant_attachment.verification_status' => $this->attachment_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])                                   
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
	    //->andFilterWhere(['like', 'education.registration_number',$this->f4indexno])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        if($this->date_verified !='' && $this->date_verified2 !=''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified !='' && $this->date_verified2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified =='' && $this->date_verified2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }
        

        return $dataProvider;
    }
    public function searchVerificationIncompleteReport($params,$condition)
    {
        $loggedin = Yii::$app->user->identity->user_id;
        $query = Application::find()
                              ->where(['application.verification_status'=>$condition,'application.loan_application_form_status'=>3]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        $query->joinWith("applicantAttachments")->groupBy(['applicant_attachment.application_id']);
        $query->joinWith("educations")->groupBy(['education.application_id']);
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        //$query->leftJoin('applicant_attachment', 'applicant_attachment.application_id=application.application_id');
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->officer,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'application.assignee'=>$this->assignee,
			'applicant_attachment.verification_status' => $this->attachment_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])                                   
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])    
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        if($this->date_verified !='' && $this->date_verified2 !=''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified !='' && $this->date_verified2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified =='' && $this->date_verified2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }
        
        if($this->assigned_at !='' && $this->assigned_at2 !=''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }else if($this->assigned_at !='' && $this->assigned_at2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->assigned_at." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->assigned_at =='' && $this->assigned_at2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->assigned_at2." 23:59:59"]);
        }
        

        return $dataProvider;
    }
    public function searchVerificationcompleteToRelease($params)
    {
        $loggedin = Yii::$app->user->identity->user_id;
        $query = Application::find()
                              ->where(['application.verification_status'=>1,'application.loan_application_form_status'=>3,'application.is_migration_data'=>0])
                              ->andWhere(['or',
                   ['application.released'=>NULL],
                   ['application.released'=>''],
                                    ]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        $query->joinWith("applicantAttachments")->groupBy(['applicant_attachment.application_id']);
        $query->joinWith("educations")->groupBy(['education.application_id']);
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant")->where(['applicant.is_migration_data'=>0]);
        $query->joinwith(["applicant","applicant.user"])->where(['user.is_migration_data'=>0]);
        //$query->leftJoin('applicant_attachment', 'applicant_attachment.application_id=application.application_id');
        $query->joinWith("academicYear")->where(['academic_year.is_current'=>1]);
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->officer,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'application.assignee'=>$this->assignee,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])                                   
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])    
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        if($this->date_verified !='' && $this->date_verified2 !=''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified !='' && $this->date_verified2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified =='' && $this->date_verified2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }
        
        if($this->assigned_at !='' && $this->assigned_at2 !=''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }else if($this->assigned_at !='' && $this->assigned_at2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->assigned_at." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->assigned_at =='' && $this->assigned_at2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->assigned_at2." 23:59:59"]);
        }
        

        return $dataProvider;
    }
    public function searchVerificationAssignmentReport($params,$condition)
    {
        $loggedin = Yii::$app->user->identity->user_id;
        $query = Application::find()
                              ->where(['application.verification_status'=>$condition,'application.loan_application_form_status'=>3])
                              ->andWhere(['>','application.assignee',0]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        $query->joinWith("applicantAttachments")->groupBy(['applicant_attachment.application_id']);
        $query->joinWith("educations")->groupBy(['education.application_id']);
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        //$query->leftJoin('applicant_attachment', 'applicant_attachment.application_id=application.application_id');
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->officer,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'application.assignee'=>$this->assignee,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])                                   
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])    
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        if($this->date_verified !='' && $this->date_verified2 !=''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified !='' && $this->date_verified2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified =='' && $this->date_verified2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }
        
        if($this->assigned_at !='' && $this->assigned_at2 !=''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }else if($this->assigned_at !='' && $this->assigned_at2 ==''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->assigned_at =='' && $this->assigned_at2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }
        

        return $dataProvider;
    }
    public function searchReverseVerification($params,$condition)
    {
        $loggedin = Yii::$app->user->identity->user_id;
        $query = Application::find()
                              ->where(['application.verification_status'=>$condition,'application.loan_application_form_status'=>3,'released'=>NULL]);
                              //->andWhere(['>','application.assignee',0]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        $query->joinWith("applicantAttachments")->groupBy(['applicant_attachment.application_id']);
        $query->joinWith("educations")->groupBy(['education.application_id']);
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        //$query->leftJoin('applicant_attachment', 'applicant_attachment.application_id=application.application_id');
        $query->joinWith("academicYear");
        $query->joinWith("verificationFramework");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->officer,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'application.assignee'=>$this->assignee,
            'application.verification_framework_id'=>$this->verification_framework_id,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])                                   
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])    
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        if($this->date_verified !='' && $this->date_verified2 !=''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified !='' && $this->date_verified2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified =='' && $this->date_verified2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }
        
        if($this->assigned_at !='' && $this->assigned_at2 !=''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }else if($this->assigned_at !='' && $this->assigned_at2 ==''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->assigned_at =='' && $this->assigned_at2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }
        

        return $dataProvider;
    }
	public function searchIndex($params)
    {
        $query = Application::find();
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->joinWith("programme");
        $query->joinWith("educations");
        $query->joinWith("programme.learningInstitution");
         $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
			->andFilterWhere(['like', 'application_form_number', $this->application_form_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'education.registration_number', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);

        return $dataProvider;
    }
    
    public function searchAssignedApplicationSummary($params)
    {
        $query = Application::find()
                              ->select('application.assignee')
                              ->where(['application.loan_application_form_status'=>3])
                              ->andWhere(['>','application.assignee',0])
                              ->groupBy(['application.assignee']);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->assignee,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status]);
        return $dataProvider;
    }
    
    public function searchVerificationAssignedReattached($params)
    {
        $query = Application::find()
                              ->andWhere(['application.verification_status'=>[0,2,3,4,5],'resubmit'=>1,'reattached_assigned_status'=>1])
                              ->andWhere(['not',
                                  ['application.assignee'=>NULL],
                                  ])
                               ->andWhere(['not',
                                  ['application.assignee'=>''],
                                  ]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        //$query->joinWith("educations");
        $query->joinWith("educations")->groupBy(['education.application_id']);
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'assignee' => $this->assignee,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,	                
            'assignee' => $this->assignee3,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'assignee' => $this->assignee_asi,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])    
            ->andFilterWhere(['like', 'user.surname', $this->surname])
	    //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            //->andFilterWhere(['like', 'education.registration_number', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])    
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        //$query->where($condition);

        return $dataProvider;
    }
    
    public function searchAssignedApplicationSummaryReattached($params)
    {
        $query = Application::find()
                              ->select('application.assignee')
                              ->where(['application.loan_application_form_status'=>3,'resubmit'=>1,'reattached_assigned_status'=>1])
                              ->andWhere(['>','application.assignee',0])
                              ->groupBy(['application.assignee']);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->assignee,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status]);
        return $dataProvider;
    }
    public function searchReattachedApplication($params)
    {
        $loggedin = Yii::$app->user->identity->user_id;
        $query = Application::find()
                              ->where(['application.resubmit'=>'1','application.reattached_assigned_status'=>'1','application.attempted_reattached_status'=>'0','application.loan_application_form_status'=>3,'assignee'=>$loggedin]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        //$query->joinWith("educations");
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])    
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            //->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        //$query->where($condition);

        return $dataProvider;
    }
    public function searchAllReattachedApplication($params)
    {
        $loggedin = Yii::$app->user->identity->user_id;
        $query = Application::find()
                              ->where(['application.resubmit'=>'1','application.loan_application_form_status'=>3]);
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        //$query->joinWith("educations");
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category_id,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])    
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            //->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        //$query->where($condition);

        return $dataProvider;
    }
    public function searchHelpDesk($params)
    {
        
         $query = Application::find()->where(['application.is_migration_data'=>0]);
                              
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        $query->joinWith("applicantAttachments")->groupBy(['applicant_attachment.application_id']);
        $query->joinWith("educations")->groupBy(['education.application_id']);
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        //$query->leftJoin('applicant_attachment', 'applicant_attachment.application_id=application.application_id');
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->officer,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'application.assignee'=>$this->assignee,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'application.application_form_number', $this->application_form_number])    
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])                                   
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])    
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        if($this->date_verified !='' && $this->date_verified2 !=''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified !='' && $this->date_verified2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified =='' && $this->date_verified2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }
        
        if($this->assigned_at !='' && $this->assigned_at2 !=''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }else if($this->assigned_at !='' && $this->assigned_at2 ==''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->assigned_at =='' && $this->assigned_at2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }
        

        return $dataProvider;
    }
	  public function searchHelpDesk2($params)
    {
	$query = Application::find()
            ->select('application.application_id')
			/*
            ->with('task')
            ->where(['LIKE', 'content', 'keywordInContent'])
            ->andWhere(['publish_status' => 1])
            ->orderBy('updated_at')
            ->limit(20)
			*/
			
			// grid filtering conditions
        //$query->joinWith("programme");
        ->joinWith("applicantAttachments")->groupBy(['applicant_attachment.application_id'])
        ->joinWith("educations")->groupBy(['education.application_id'])
        //$query->joinWith("programme.learningInstitution");
        ->joinwith("applicant")
        ->joinwith(["applicant","applicant.user"])
        //$query->leftJoin('applicant_attachment', 'applicant_attachment.application_id=application.application_id');
        ->joinWith("academicYear")
        ->andFilterWhere([
            'application.application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->officer,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'application.assignee'=>$this->assignee,
        ])

            ->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])                                   
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])    
            ->andFilterWhere(['=', 'academic_year.is_current', 1])
            ->one();
			
	return $query;		
	}
        
        public function searchHelpDeskInitiate($params)
    {
        
         $query = Application::find()->where(['application.application_id'=>-1]);
                              
                           
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=>false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->joinWith("programme");
        $query->joinWith("applicantAttachments")->groupBy(['applicant_attachment.application_id']);
        $query->joinWith("educations")->groupBy(['education.application_id']);
        //$query->joinWith("programme.learningInstitution");
        $query->joinwith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
        //$query->leftJoin('applicant_attachment', 'applicant_attachment.application_id=application.application_id');
        $query->joinWith("academicYear");
        $query->andFilterWhere([
            'application_id' => $this->application_id,
            'applicant_id' => $this->applicant_id,
            'learning_institution.learning_institution_id' => $this->instititution,
            'academic_year_id' => $this->academic_year_id,
            'amount_paid' => $this->amount_paid,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'programme_id' => $this->programme_id,
            'application_study_year' => $this->application_study_year,
            'current_study_year' => $this->current_study_year,
            'applicant_category_id' => $this->applicant_category,
            'bank_id' => $this->bank_id,
            'submitted' => $this->submitted,
            //'verification_status' => $this->verification_status,
            'needness' => $this->needness,
            'allocation_status' => $this->allocation_status,
            'created_at' => $this->created_at,
            'assignee' => $this->officer,
            'applicant.sex' => $this->sex,
            'application.verification_status' => $this->verification_status,
            'applicant_attachment.comment' => $this->verification_comment,
            'application.assignee'=>$this->assignee,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.middlename', $this->middlename])                                   
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['or',
           ['like', 'applicant.f4indexno', $this->f4indexno],
           ['like', 'education.registration_number',$this->f4indexno]
                ])    
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);
        if($this->date_verified !='' && $this->date_verified2 !=''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified !='' && $this->date_verified2 ==''){
            $query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->date_verified =='' && $this->date_verified2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }
        
        if($this->assigned_at !='' && $this->assigned_at2 !=''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }else if($this->assigned_at !='' && $this->assigned_at2 ==''){
            $query->andFilterWhere(['>=', 'application.assigned_at', $this->assigned_at." 00:00:00"]);
            //$query->andFilterWhere(['<=', 'application.date_verified', $this->date_verified2." 23:59:59"]);
        }else if($this->assigned_at =='' && $this->assigned_at2 !=''){
            //$query->andFilterWhere(['>=', 'application.date_verified', $this->date_verified." 00:00:00"]);
            $query->andFilterWhere(['<=', 'application.assigned_at', $this->assigned_at2." 23:59:59"]);
        }
        

        return $dataProvider;
    }
        
}

