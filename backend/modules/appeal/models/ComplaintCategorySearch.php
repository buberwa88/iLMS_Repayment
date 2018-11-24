<?php

namespace backend\modules\appeal\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\appeal\models\ComplaintCategory;

/**
 * backend\modules\appeal\models\ComplaintCategorySearch represents the model behind the search form about `backend\modules\appeal\models\ComplaintCategory`.
 */
 class ComplaintCategorySearch extends ComplaintCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['complaint_category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['complaint_category_name', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = ComplaintCategory::find();

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
            'complaint_category_id' => $this->complaint_category_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'complaint_category_name', $this->complaint_category_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
