<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\VerificationComment;

/**
 * VerificationCommentSearch represents the model behind the search form about `backend\modules\application\models\VerificationComment`.
 */
class VerificationCommentSearch extends VerificationComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_comment_id', 'verification_comment_group_id', 'comment', 'created_by'], 'integer'],
            [['created_at','attachment_definition_id'], 'safe'],
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
        $query = VerificationComment::find();

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
            'verification_comment_id' => $this->verification_comment_id,
            'verification_comment_group_id' => $this->verification_comment_group_id,
            'comment' => $this->comment,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
