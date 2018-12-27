<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\EmployedBeneficiary;

/**
 * EmployedBeneficiarySearch represents the model behind the search form about `frontend\modules\repayment\models\EmployedBeneficiary`.
 */
class EmployedBeneficiarySearch extends EmployedBeneficiary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employed_beneficiary_id', 'employer_id', 'applicant_id', 'created_by'], 'integer'],
            [['employee_id', 'employment_status', 'created_at','employee_check_number','employee_f4indexno','employee_mobile_phone_no',
                'employee_year_completion_studies','employee_academic_awarded','employee_instituitions_studies','employee_NIN','employee_check_number','firstname','surname','middlename','f4indexno','employerName','upload_error','confirmed'], 'safe'],
            [['basic_salary'], 'number'],
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
            'confirmed' => $this->confirmed,
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
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
    public function getEmployeesUnderEmployer($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    ->where(['employer_id'=>$employerID])
                                    ->orderBy('employed_beneficiary_id DESC');
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
            'confirmed' => $this->confirmed,
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
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	
	public function getUnconfirmedBeneficiaries($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    ->where(['employed_beneficiary.employer_id'=>$employerID,'employed_beneficiary.verification_status'=>'3'])
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
            'confirmed' => $this->confirmed,
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
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
    public function getUnconfirmedBeneficiaries2($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    ->where(['employed_beneficiary.employer_id'=>$employerID,'employed_beneficiary.verification_status'=>'1','employed_beneficiary.loan_confirmed'=>0])
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
            'confirmed' => $this->confirmed,
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
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	public function getVerifiedEmployeesUnderEmployer($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    ->andWhere(['employed_beneficiary.employer_id'=>$employerID,'employed_beneficiary.employment_status'=>'ONPOST'])									
									->andWhere(['or',
                                        ['employed_beneficiary.verification_status'=>1],
                                        ['employed_beneficiary.verification_status'=>5],
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
            'confirmed' => $this->confirmed,
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
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	
	public function getDisabledEmployedBeneficiary($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    //->andwhere(['employed_beneficiary.employer_id'=>$employerID,'employed_beneficiary.verification_status'=>5])
									->andwhere(['employed_beneficiary.employer_id'=>$employerID])
									->andWhere(['not', ['employed_beneficiary.employment_status'=>'ONPOST']])
									->andWhere(['not', ['employed_beneficiary.applicant_id'=>null]])
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
            'confirmed' => $this->confirmed,
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
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	
	public function getNonVerifiedEmployees($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    ->andWhere(['employed_beneficiary.employer_id'=>$employerID,'employed_beneficiary.upload_status'=>1])
									->andWhere(['or',
                                        ['employed_beneficiary.verification_status'=>0],
                                        ['employed_beneficiary.verification_status'=>4],
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
            'confirmed' => $this->confirmed,
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
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
    public function getFailedUploadedEmployees($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    ->andWhere(['employed_beneficiary.employer_id'=>$employerID,'employed_beneficiary.upload_status'=>0])
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
            'confirmed' => $this->confirmed,
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
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
	    ->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'upload_error', $this->upload_error])    
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
	public function getEmployeesUnderEmployerNonBeneficiary($params,$employerID)
    {
        $query = EmployedBeneficiary::find()
                                    ->where(['employed_beneficiary.employer_id'=>$employerID,'employed_beneficiary.verification_status'=>6])
                                    ->orderBy('employed_beneficiary_id DESC');
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
            'confirmed' => $this->confirmed,
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
            ->andFilterWhere(['like', 'employee_mobile_phone_no', $this->employee_mobile_phone_no])
            ->andFilterWhere(['like', 'employee_year_completion_studies', $this->employee_year_completion_studies])
            ->andFilterWhere(['like', 'employee_academic_awarded', $this->employee_academic_awarded])
            ->andFilterWhere(['like', 'employee_instituitions_studies', $this->employee_instituitions_studies])
            ->andFilterWhere(['like', 'employee_NIN', $this->employee_NIN])
			->andFilterWhere(['like', 'basic_salary', $this->basic_salary])
            ->andFilterWhere(['like', 'employee_check_number', $this->employee_check_number]);

        return $dataProvider;
    }
}
