<?php

namespace frontend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\application\models\Application;

/**
 * ApplicationSearch represents the model behind the search form about `frontend\modules\application\models\Application`.
 */
class ApplicationSearch extends Application
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_id', 'applicant_id', 'academic_year_id', 'programme_id', 'application_study_year', 'current_study_year', 'applicant_category_id', 'bank_id', 'submitted', 'verification_status', 'allocation_status'], 'integer'],
            [['bill_number', 'control_number', 'receipt_number', 'pay_phone_number', 'date_bill_generated', 'date_control_received', 'date_receipt_received', 'bank_account_number', 'bank_account_name', 'bank_branch_name', 'allocation_comment', 'student_status', 'created_at'], 'safe'],
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
            ->andFilterWhere(['like', 'student_status', $this->student_status]);

        return $dataProvider;
    }
}
