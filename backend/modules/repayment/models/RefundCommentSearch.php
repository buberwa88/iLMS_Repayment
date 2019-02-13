<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\RefundComment;

/**
 * backend\modules\repayment\models\RefundCommentSearch represents the model behind the search form about `backend\modules\repayment\models\RefundComment`.
 */
 class RefundCommentSearch extends RefundComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_comment_id', 'attachment_definition_id', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['comment', 'created_at', 'updated_at'], 'safe'],
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
        $query = RefundComment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'refund_comment_id' => $this->refund_comment_id,
            'attachment_definition_id' => $this->attachment_definition_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
