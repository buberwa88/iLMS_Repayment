<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\Employer;
use frontend\modules\application\models\Applicant;

/**
 * EmployerSearch represents the model behind the search form about `frontend\modules\repayment\models\Employer`.
 */
class EmployerSearch extends Employer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_id', 'user_id', 'ward_id','district'], 'integer'],
            [['employer_name', 'employer_code', 'employer_type_id', 'postal_address', 'phone_number', 'physical_address', 'email_address', 'created_at'], 'safe'],
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
        $query = Employer::find();

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
            'employer_id' => $this->employer_id,
            'user_id' => $this->user_id,
            'ward_id' => $this->ward_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'employer_name', $this->employer_name])
            ->andFilterWhere(['like', 'employer_code', $this->employer_code])
            ->andFilterWhere(['like', 'employer_type_id', $this->employer_type_id])
            ->andFilterWhere(['like', 'postal_address', $this->postal_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'physical_address', $this->physical_address])
            ->andFilterWhere(['like', 'email_address', $this->email_address]);

        return $dataProvider;
    }
    
    public function employerBillRequestPending($params)
    {
        $query = Employer::find();
                         //->where(['loan_summary_requested'=>'1']);

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
            'employer_id' => $this->employer_id,
            'user_id' => $this->user_id,
            'ward_id' => $this->ward_id,
           
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'employer_name', $this->employer_name])
            ->andFilterWhere(['like', 'employer_code', $this->employer_code])
            ->andFilterWhere(['like', 'employer_type_id', $this->employer_type_id])
            ->andFilterWhere(['like', 'postal_address', $this->postal_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'physical_address', $this->physical_address])
            ->andFilterWhere(['like', 'email_address', $this->email_address]);

        return $dataProvider;
    }
    
    public static function getEmployer($loggedin){
        $employerDetails = Employer::find()
                            ->where(['user_id'=>$loggedin])
                            ->limit(1)->one();
        return $employerDetails;
        }

    public static function getApplicant($loggedin){
        $employerDetails = Applicant::find()
                            ->where(['user_id'=>$loggedin])
                            ->limit(1)->one();
        return $employerDetails;
        }
}
