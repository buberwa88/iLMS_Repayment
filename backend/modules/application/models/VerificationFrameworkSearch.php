<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\VerificationFramework;

/**
 * VerificationFrameworkSearch represents the model behind the search form about `backend\modules\application\models\VerificationFramework`.
 */
class VerificationFrameworkSearch extends VerificationFramework
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_framework_id', 'verification_framework_stage', 'created_by', 'confirmed_by', 'is_active'], 'integer'],
            [['verification_framework_title', 'verification_framework_desc', 'created_at', 'confirmed_at','category'], 'safe'],
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
        $query = VerificationFramework::find();

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

        $query->joinWith("category0");

        $query->andFilterWhere([
            'verification_framework_id' => $this->verification_framework_id,
            'verification_framework_stage' => $this->verification_framework_stage,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'confirmed_by' => $this->confirmed_by,
            'confirmed_at' => $this->confirmed_at,
            'is_active' => $this->is_active,
            'category'=>$this->category,
        ]);

        $query->andFilterWhere(['like', 'verification_framework_title', $this->verification_framework_title])
            ->andFilterWhere(['like', 'verification_framework_desc', $this->verification_framework_desc]);

        return $dataProvider;
    }
}
