<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\VerificationCommentGroup;

/**
 * VerificationCommentGroupSearch represents the model behind the search form about `backend\modules\application\models\VerificationCommentGroup`.
 */
class VerificationCommentGroupSearch extends VerificationCommentGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_comment_group_id', 'created_by'], 'integer'],
            [['comment_group', 'created_at'], 'safe'],
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
        $query = VerificationCommentGroup::find();

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
            'verification_comment_group_id' => $this->verification_comment_group_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'comment_group', $this->comment_group]);

        return $dataProvider;
    }
}
