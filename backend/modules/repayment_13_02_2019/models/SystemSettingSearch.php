<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\SystemSetting;

/**
 * SystemSettingSearch represents the model behind the search form about `backend\modules\repayment\models\SystemSetting`.
 */
class SystemSettingSearch extends SystemSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['system_setting_id', 'is_active'], 'integer'],
            [['setting_name', 'setting_code', 'setting_value', 'value_data_type'], 'safe'],
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
        $query = SystemSetting::find()->where(['setting_code'=>['LRGPD','EMLRP','SEMLRA','CMR','TNDY']]);

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
            'system_setting_id' => $this->system_setting_id,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'setting_name', $this->setting_name])
            ->andFilterWhere(['like', 'setting_code', $this->setting_code])
            ->andFilterWhere(['like', 'setting_value', $this->setting_value])
            ->andFilterWhere(['like', 'value_data_type', $this->value_data_type]);

        return $dataProvider;
    }
}
