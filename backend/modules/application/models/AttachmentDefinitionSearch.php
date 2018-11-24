<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\AttachmentDefinition;

/**
 * AttachmentDefinitionSearch represents the model behind the search form about `backend\modules\application\models\AttachmentDefinition`.
 */
class AttachmentDefinitionSearch extends AttachmentDefinition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attachment_definition_id', 'require_verification', 'is_active'], 'integer'],
            [['attachment_desc', 'verification_prompt'], 'safe'],
            [['max_size_MB'], 'number'],
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
        $query = AttachmentDefinition::find();

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
            'attachment_definition_id' => $this->attachment_definition_id,
            'max_size_MB' => $this->max_size_MB,
            'require_verification' => $this->require_verification,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'attachment_desc', $this->attachment_desc])
            ->andFilterWhere(['like', 'verification_prompt', $this->verification_prompt]);

        return $dataProvider;
    }
}

