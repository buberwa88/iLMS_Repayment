<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LoanBeneficiary;
use \frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Application;
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
	 
    public function rules()
    {
        return [
            [['loan_beneficiary_id', 'place_of_birth', 'learning_institution_id','applicationID','academic_year_id','learrning_instituition_id'], 'integer'],
            [['firstname', 'middlename', 'surname', 'f4indexno', 'olevel_index', 'NID', 'date_of_birth', 'postal_address', 'physical_address', 'phone_number', 'email_address', 'password','sex'], 'safe'],
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
		                    //->joinWith(['applications']);
							$query->joinWith(['user']);
							$query->joinWith(['applications']);							
							$query->joinWith(['applications','applications.educations']);
							$query->joinWith(['applications','applications.educations','applications.educations.learningInstitution']);
                                    //->andWhere(['employed_beneficiary.employer_id'=>$employerID])
									//->andWhere(['or',
                                        //['employed_beneficiary.verification_status'=>0],
                                        //['employed_beneficiary.verification_status'=>4],
                                   // ])
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
         //$query->joinwith(["user"]);

		// grid filtering conditions
        $query->andFilterWhere([
            'applicant.applicant_id' => $this->applicant_id,
            'applicant.user_id' => $this->user_id,
            'applicant.date_of_birth' => $this->date_of_birth,
            'application.academic_year_id' => $this->academic_year_id,
            'learning_institution_id' => $this->learning_institution_id,        			
            
        ]);

        $query->andFilterWhere(['like', 'NID', $this->NID])
              ->andFilterWhere(['like', 'place_of_birth', $this->place_of_birth])
			  ->andFilterWhere(['like', 'application.application_id', $this->applicationID])
			  ->andFilterWhere(['like', 'education.olevel_index', $this->olevel_index])
			  ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			  ->andFilterWhere(['like', 'user.middlename', $this->middlename])
			  ->andFilterWhere(['like', 'user.surname', $this->surname]);

        return $dataProvider;
    }
	
}
