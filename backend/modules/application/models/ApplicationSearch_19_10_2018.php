<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\Application;

/**
 * ApplicationSearch represents the model behind the search form about `backend\modules\application\models\Application`.
 */
class ApplicationSearch extends Application
{
    /**
     * @inheritdoc
     */
        public  $instititution;
        public $programme_id;
        public $firstName;
        public $surname;
        public $f4indexno;
        public $gender;
    public function rules()
    {
        return [
            [['application_id', 'applicant_id', 'academic_year_id', 'programme_id', 'application_study_year', 'current_study_year', 'applicant_category_id', 'bank_id', 'submitted', 'verification_status', 'allocation_status'], 'integer'],
            [['bill_number','firstName','surname','gender','f4indexno','programme_id','control_number','registration_number', 'receipt_number', 'pay_phone_number', 'date_bill_generated', 'date_control_received', 'date_receipt_received', 'bank_account_number', 'bank_account_name', 'bank_branch_name', 'allocation_comment', 'student_status', 'created_at','instititution'], 'safe'],
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
    public function search($params)
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
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
           ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'applicant.sex', $this->gender])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"])
            ->andFilterWhere(['=', 'academic_year.is_current', 1]);

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
            //'programme_id' => $this->programme_id,
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
/*
 *  $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->orFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->orFilterWhere(['like', 'applicant.sex', $this->gender])
            ->orFilterWhere(['like', 'application.programme_id', $this->programme_id])
            ->andFilterWhere(['like', 'student_status', $this->student_status]);
 */
        $query->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'application.programme_id', $this->programme_id]);
           

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
            ->andFilterWhere(['like', 'applicant.sex', $this->gender])
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
           
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'applicant.sex', $this->gender])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);
        return $dataProvider;
    }
       public function searchMeansTested($params,$value)
    {
        $query = Application::find()->where(['in','allocation_status',$value]);
                           
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
            ->andFilterWhere(['like', 'applicant.sex', $this->gender])
            ->andFilterWhere(['like', 'student_status', $this->student_status]);

        return $dataProvider;
    }
         public function searchComputeNeedness($params)
    {
        $query = Application::find()->where(['allocation_status'=>5,'progress_status'=>2]);
                           
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
            ->andFilterWhere(['like', 'applicant.sex', $this->gender])
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
            ->andFilterWhere(['like', 'applicant.sex', $this->gender])
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
            ->andFilterWhere(['like', 'applicant.sex', $this->gender])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);
        return $dataProvider;
    }
     public function searcheligible($params)
    {
        $query = Application::find()->where(['in','allocation_status',[1,3,4,5]]);
                           
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
            ->andFilterWhere(['like', 'applicant.sex', $this->gender])
            ->andFilterWhere(['like', 'student_status', $this->student_status]);

        return $dataProvider;
    }
     public function searchnoteligible($params)
    {
        $query = Application::find()->where(['in','allocation_status',[2]]);
                           
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
            ->andFilterWhere(['like', 'applicant.sex', $this->gender])
            ->andFilterWhere(['like', 'student_status', $this->student_status]);

        return $dataProvider;
    }
    public function searchIndexApplicant($params,$applicantID)
    {
        $query = Application::find()->where(['application.applicant_id'=>$applicantID]);
                           
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
            'application.academic_year_id' => $this->academic_year_id,
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
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'allocation_comment', $this->allocation_comment])
            ->andFilterWhere(['like', 'student_status', $this->student_status])
            ->andFilterWhere(['like', 'user.firstname', $this->firstName])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'education.registration_number', $this->f4indexno])
            ->andFilterWhere(['like', 'education.level',"OLEVEL"]);
            //->andFilterWhere(['=', 'academic_year.is_current', 1]);

        return $dataProvider;
    }
}

