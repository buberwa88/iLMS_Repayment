<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LoanBeneficiary;
use \frontend\modules\application\models\Applicant;
use backend\modules\application\models\Application;
use frontend\modules\application\models\Education;


/**
 * LoanBeneficiarySearch represents the model behind the search form about `frontend\modules\repayment\models\LoanBeneficiary`.
 */
class LoanBeneficiarySearch extends LoanBeneficiary
{
    /**
     * @inheritdoc
     */
	 public $user_id;
	 public $olevel_index;
	 public $applicationID;
	 public $academic_year_id;
	 public $learrning_instituition_id;
	 public $check_search;
	 
    public function rules()
    {
        return [
            [['loan_beneficiary_id', 'place_of_birth', 'learning_institution_id','applicationID','academic_year_id','learrning_instituition_id'], 'integer'],
            [['firstname', 'middlename', 'surname', 'f4indexno', 'olevel_index', 'NID', 'date_of_birth', 'postal_address', 'physical_address', 'phone_number', 'email_address', 'password','sex','check_search'], 'safe'],
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
        $query = LoanBeneficiary::find()
		                          ->where(['loan_beneficiary.applicant_id'=>NULL])
		                          ->orderBy('loan_beneficiary.loan_beneficiary_id DESC');

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
        $query->andFilterWhere([
            'loan_beneficiary_id' => $this->loan_beneficiary_id,
            'date_of_birth' => $this->date_of_birth,
            'place_of_birth' => $this->place_of_birth,
            'learning_institution_id' => $this->learning_institution_id,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'surname', $this->surname])
			->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'NID', $this->NID])
            ->andFilterWhere(['like', 'postal_address', $this->postal_address])
            ->andFilterWhere(['like', 'physical_address', $this->physical_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
	
	public function getAllLoanees($params)
    {
        $query = Applicant::find();
		$query->joinWith(['user']);
		$query->joinWith(['applications'])->groupBy(['application.application_id'])->orderBy(['application.application_id' => SORT_DESC]);
		$query->joinWith('applications','applications.educations')->groupBy(['application_id']);
                //$query->joinWith(['applications','applications.disbursements'])->groupBy(['disbursement.application_id']);
                //$query->joinWith(['applications','applications.disbursements','applications.disbursements.programme']);
                //$query->joinWith(['applications','applications.disbursements','applications.disbursements.disbursementBatch']);
		

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
         //$query->joinwith(["user"]);

		// grid filtering conditions
        $query->andFilterWhere([
            'applicant.applicant_id' => $this->applicant_id,
            'applicant.user_id' => $this->user_id,
            'applicant.date_of_birth' => $this->date_of_birth,
            'application.academic_year_id' => $this->academic_year_id,
            'programme.learning_institution_id' => $this->learning_institution_id,        			
            
        ]);

        $query->andFilterWhere(['like', 'applicant.NID', $this->NID])
              ->andFilterWhere(['like', 'applicant.place_of_birth', $this->place_of_birth])
	      ->andFilterWhere(['like', 'application.application_id', $this->applicationID])
	      ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
	      ->andFilterWhere(['like', 'user.firstname', $this->firstname])
	      ->andFilterWhere(['like', 'user.middlename', $this->middlename])
          //->andFilterWhere(['like', 'education.level',"OLEVEL"])  
	      ->andFilterWhere(['like', 'user.surname', $this->surname]);

        return $dataProvider;
    }
	public function searchRepaymentInitiate($params)
    {
        $query = Applicant::find()->where(['applicant.applicant_id'=>-1]);
		                      //->select('applicant.applicant_id,applicant.f4indexno')->where(['applicant.applicant_id'=>30]);
		                    //->joinWith(['applications']);
		$query->joinWith(['user']);
		$query->joinWith(['applications'])->groupBy(['application.application_id'])->orderBy(['application.application_id' => SORT_DESC]);
                $query->joinWith(['applications','applications.disbursements'])->groupBy(['disbursement.application_id']);
                $query->joinWith(['applications','applications.disbursements','applications.disbursements.programme']);
                $query->joinWith(['applications','applications.disbursements','applications.disbursements.disbursementBatch']);
		

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
         //$query->joinwith(["user"]);

		// grid filtering conditions
        $query->andFilterWhere([
            'applicant.applicant_id' => $this->applicant_id,
            'applicant.user_id' => $this->user_id,
            'applicant.date_of_birth' => $this->date_of_birth,
            'application.academic_year_id' => $this->academic_year_id,
            'programme.learning_institution_id' => $this->learning_institution_id,        			
            
        ]);

        $query->andFilterWhere(['like', 'applicant.NID', $this->NID])
              ->andFilterWhere(['like', 'applicant.place_of_birth', $this->place_of_birth])
	      ->andFilterWhere(['like', 'application.application_id', $this->applicationID])
	      ->andFilterWhere(['like', 'applicant.f4indexno', $this->olevel_index])
	      ->andFilterWhere(['like', 'user.firstname', $this->firstname])
	      ->andFilterWhere(['like', 'user.middlename', $this->middlename])
              //->andFilterWhere(['like', 'education.level',"OLEVEL"])  
	      ->andFilterWhere(['like', 'user.surname', $this->surname]);

        return $dataProvider;
    }
	
}
