<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\GepgBill;

/**
 * GepgBillSearch represents the model behind the search form about `backend\modules\application\models\GepgBill`.
 */
class GepgBillSearch extends GepgBill
{
    /**
     * @inheritdoc
     */
	 public $f4indexno;
	 public $control_number;
    public function rules()
    {
        return [
            [['id', 'retry', 'status', 'cancelled_by', 'cancelled_response_status'], 'integer'],
            [['bill_number', 'bill_request', 'response_message', 'date_created', 'cancelled_reason', 'cancelled_date', 'cancelled_response_code','payer','control_number','bill_amount','application_id','f4indexno','control_number'], 'safe'],
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
        $query = GepgBill::find()
		                 ->orderBy('id DESC');

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
		
		$query->joinWith("application");
		$query->joinwith(["application","application.applicant"]);
        $query->andFilterWhere([
            'id' => $this->id,
            'retry' => $this->retry,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'cancelled_by' => $this->cancelled_by,
            'cancelled_date' => $this->cancelled_date,
            'cancelled_response_status' => $this->cancelled_response_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'bill_request', $this->bill_request])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
			->andFilterWhere(['like', 'application.control_number', $this->control_number])
            ->andFilterWhere(['like', 'response_message', $this->response_message])
            ->andFilterWhere(['like', 'cancelled_reason', $this->cancelled_reason])
            ->andFilterWhere(['like', 'cancelled_response_code', $this->cancelled_response_code]);

        return $dataProvider;
    }
}
