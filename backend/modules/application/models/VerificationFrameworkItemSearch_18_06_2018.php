<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\VerificationFrameworkItem;

/**
 * VerificationFrameworkItemSearch represents the model behind the search form about `backend\modules\application\models\VerificationFrameworkItem`.
 */
class VerificationFrameworkItemSearch extends VerificationFrameworkItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_framework_item_id', 'verification_framework_id', 'attachment_definition_id', 'created_by', 'is_active'], 'integer'],
            [['attachment_desc', 'verification_prompt', 'created_at'], 'safe'],
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
        $query = VerificationFrameworkItem::find();

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
            'verification_framework_item_id' => $this->verification_framework_item_id,
            'verification_framework_id' => $this->verification_framework_id,
            'attachment_definition_id' => $this->attachment_definition_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'attachment_desc', $this->attachment_desc])
            ->andFilterWhere(['like', 'verification_prompt', $this->verification_prompt]);

        return $dataProvider;
    }
}
