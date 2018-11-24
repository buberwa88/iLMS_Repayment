<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\LoanRepaymentSetting;

/**
 * LoanRepaymentSettingSearch represents the model behind the search form about `backend\modules\repayment\models\LoanRepaymentSetting`.
 */
class LoanRepaymentSettingSearch extends LoanRepaymentSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_repayment_setting_id', 'loan_repayment_item_id', 'created_by','is_active','calculation_mode'], 'integer'],
            [['start_date', 'end_date', 'created_at','item_name'], 'safe'],
            [['rate'], 'number'],
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
        $query = LoanRepaymentSetting::find()
		                                  ->orderBy('is_active DESC');

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
		$query->joinWith("loanRepaymentItem");		
        $query->andFilterWhere([
            'loan_repayment_setting_id' => $this->loan_repayment_setting_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'rate' => $this->rate,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
			'loan_repayment_setting.is_active'=> $this->is_active,
			'calculation_mode' => $this->calculation_mode,
        ]);
		$query->andFilterWhere(['like', 'loan_repayment_item_id', $this->loan_repayment_item_id])
		      ->andFilterWhere(['like', 'loan_repayment_item.item_name', $this->item_name]);

        return $dataProvider;
    }
}
