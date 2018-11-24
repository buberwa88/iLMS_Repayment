<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\DisbursementSetting;

/**
 * DisbursementSettingSearch represents the model behind the search form about `backend\modules\disbursement\models\DisbursementSetting`.
 */
class DisbursementSettingSearch extends DisbursementSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_setting_id', 'academic_year_id', 'instalment_definition_id', 'loan_item_id'], 'integer'],
            [['percentage'], 'number'],
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
        $query = DisbursementSetting::find();

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
            'disbursement_setting_id' => $this->disbursement_setting_id,
            'academic_year_id' => $this->academic_year_id,
            'instalment_definition_id' => $this->instalment_definition_id,
            'loan_item_id' => $this->loan_item_id,
            'percentage' => $this->percentage,
        ]);

        return $dataProvider;
    }
}
