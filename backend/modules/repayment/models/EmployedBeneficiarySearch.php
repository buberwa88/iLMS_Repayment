<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\application\models\Education;

/**
 * EmployedBeneficiarySearch represents the model behind the search form about `frontend\modules\repayment\models\EmployedBeneficiary`.
 */
class EmployedBeneficiarySearch extends EmployedBeneficiary
{
    /**
     * @inheritdoc
     */
    public $sex;
    public function rules()
    {
        return [
            [['employed_beneficiary_id', 'applicant_id', 'created_by'], 'integer'],
            [['employee_id', 'employment_status', 'created_at','employee_check_number','employee_f4indexno','employee_firstname','employee_mobile_phone_no',
                'employee_year_completion_studies','employee_academic_awarded','employee_instituitions_studies','employee_NIN','employee_check_number','firstname','surname','middlename','f4indexno','employerName','outstanding','mult_employed','phone_number','sex','employer_id','vote_number'], 'safe'],
            [['basic_salary','totalLoan'], 'number'],
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
        $query = EmployedBeneficiary::find();

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
		// grid filtering conditions
         $query->joinWith("employer");
		 $query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);		
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
			->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
    public function getEmployeesUnderEmployer($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    ->where(['employed_beneficiary.employer_id'=>$employerID])
									->andWhere(['and',
                                        ['>','employed_beneficiary.loan_summary_id','0'],
                                    ])
                                    ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
    public function getEmployeesUnderEmployerVerified($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    ->where(['employed_beneficiary.employer_id'=>$employerID,'employed_beneficiary.verification_status'=>1])
                                    ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
    public function verified_beneficiaries($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                ->where('employed_beneficiary.employer_id ="'.$employerID.'" AND employed_beneficiary.verification_status="1" AND employed_beneficiary.applicant_id IS NOT NULL AND employed_beneficiary.employment_status="ONPOST"')
                ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
    public function getAllBeneficiaries($params)
    {
        $query = EmployedBeneficiary::find()
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	
	public function getBeneficiaryOnly($params)
    {
        $query = EmployedBeneficiary::find()
		                               ->where('employed_beneficiary.verification_status="1" AND employed_beneficiary.applicant_id IS NOT NULL AND employed_beneficiary.employment_status="ONPOST"')
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	
	public function getNonBeneficiaryOnly($params)
    {
        $query = EmployedBeneficiary::find()
		                               ->where('(employed_beneficiary.applicant_id IS NULL OR employed_beneficiary.applicant_id="") AND confirmed="1"')
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		//$query->joinWith("employer");
		//$query->joinWith("applicant");
         //$query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    //->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'firstname', $this->firstname])
			->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	
    public function getNewEmployedBeneficiaries($params)
    {
        $query = EmployedBeneficiary::find()
                                       ->where(['employed_beneficiary.verification_status' =>'0'])
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	
	public function getNewEmployedBeneficiariesFound($params,$employee_status)
    {
        $query = EmployedBeneficiary::find()
                                       ->where('employed_beneficiary.verification_status IN(0,4) AND employed_beneficiary.employment_status ="ONPOST" AND employed_beneficiary.applicant_id >0 AND confirmed="1" AND upload_status="1" AND employee_status="'.$employee_status.'"')
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	
	/*
	public function getNewEmployedBeneficiariesFound($params)
    {
        $query = EmployedBeneficiary::find()
                                    ->select('education.olevel_index AS olevel_index,employed_beneficiary.applicant_id AS applicant_id,employed_beneficiary.basic_salary AS basic_salary,employed_beneficiary.employer_id AS employer_id, user.firstname AS firstname,user.middlename AS middlename,user.surname AS surname,employer.employer_name AS employer_name,application.application_id AS application_id,application.receipt_number AS receipt_number,application.academic_year_id AS academic_year_id')
                                    ->innerJoin('applicant', '`applicant`.`applicant_id` = `employed_beneficiary`.`applicant_id`')
									->innerJoin('application', '`application`.`applicant_id` = `applicant`.`applicant_id`')
									->innerJoin('education', '`education`.`application_id` = `application`.`application_id`')
									->innerJoin('employer', '`employer`.`employer_id` = `employed_beneficiary`.`employer_id`')
									->innerJoin('user', '`user`.`user_id` = `applicant`.`user_id`')
									//->innerJoin('disbursement', '`disbursement`.`application_id` = `application`.`application_id`')
									->andWhere(['and',
											   'employed_beneficiary.verification_status ="0" AND employed_beneficiary.applicant_id >0',
									   ])
                                    ->groupBy('{{education}}.application_id');
									//->orderBy('loan_summary.loan_summary_id DESC');
                                       //->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		//$query->joinWith("employer");
		//$query->joinWith("applicant");
        //$query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'education.olevel_index', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	*/
	
	public function getActiveEmployedBeneficiaries($params)
    {
        $query = EmployedBeneficiary::find()
                                       ->where('employed_beneficiary.verification_status ="1" AND employed_beneficiary.applicant_id >0 AND employed_beneficiary.employment_status="ONPOST"')
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	
    
    public function getNewEmployedBeneficiariesWaitingSubmit($params)
    {
        $query = EmployedBeneficiary::find()
                                       ->where(['employed_beneficiary.verification_status' =>'3'])
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
    
    public function getEmployersWaitingBill($params)
    {
        $query = EmployedBeneficiary::find()
                                       ->where(['employed_beneficiary.verification_status' =>'1','employed_beneficiary.loan_summary_id' =>NULL])
                                       ->groupBy('employed_beneficiary.employer_id');
                                       //->orderBy('employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
	     $query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	public function getNewEmployedNewEmployeenoloan($params)
    {
        $query = EmployedBeneficiary::find()
                                       ->where('employed_beneficiary.verification_status ="4" AND employed_beneficiary.applicant_id >0 AND employee_status=0')
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	public function getGovernmentEmployees($params)
    {
        $query = EmployedBeneficiary::find()
                                       ->where('employed_beneficiary.verification_status ="1" AND employed_beneficiary.applicant_id >0 AND employed_beneficiary.employment_status="ONPOST" AND employer.salary_source="1"')
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
    
    public function getDoubleEmployed($params,$applicantID)
    {
        $query = EmployedBeneficiary::find()
                                       ->where('employed_beneficiary.employment_status ="ONPOST" AND employed_beneficiary.applicant_id="'.$applicantID.'" AND  employed_beneficiary.confirmed="1"')
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id ASC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	public function getUnmatchedEmployees($params)
    {
        $query = EmployedBeneficiary::find()
                                       ->where('employed_beneficiary.verification_status="0" AND employed_beneficiary.employment_status ="ONPOST" AND (employed_beneficiary.applicant_id IS NULL OR employed_beneficiary.applicant_id="") AND confirmed="1" AND upload_status="1"')
                                       ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            //'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employer_id])
		    //->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	public function getNonBeneficiaryUnderEmployer($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    ->where(['employed_beneficiary.employer_id'=>$employerID,'employed_beneficiary.verification_status'=>[0,2,3,4,5],'confirmed'=>1,'loan_summary_id'=>null])									
                                    ->orderBy('employed_beneficiary.employed_beneficiary_id DESC');
                                   // ->all();

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
        $query->andFilterWhere([
            'employed_beneficiary_id' => $this->employed_beneficiary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            //'basic_salary' => $this->basic_salary,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'mult_employed' => $this->mult_employed,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'employer.employer_name', $this->employerName])
		    ->andFilterWhere(['like', 'employed_beneficiary.firstname', $this->firstname])
			->andFilterWhere(['like', 'employed_beneficiary.middlename', $this->middlename])
            ->andFilterWhere(['like', 'employed_beneficiary.surname', $this->surname])
            ->andFilterWhere(['like', 'employed_beneficiary.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])                
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number])
            ->andFilterWhere(['like', 'employee_f4indexno', $this->employee_f4indexno])
            ->andFilterWhere(['like', 'employee_firstname', $this->employee_firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'totalLoan', $this->totalLoan])
			->andFilterWhere(['like', 'employed_beneficiary.basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
}
