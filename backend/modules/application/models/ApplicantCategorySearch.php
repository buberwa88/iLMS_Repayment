<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\ApplicantCategory;

/**
 * ApplicantCategorySearch represents the model behind the search form about `backend\modules\application\models\ApplicantCategory`.
 */
class ApplicantCategorySearch extends ApplicantCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applicant_category_id'], 'integer'],
            [['applicant_category','applicant_category_code'], 'safe'],
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
        $query = ApplicantCategory::find();

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
            'applicant_category_id' => $this->applicant_category_id,
        ]);

        $query->andFilterWhere(['like', 'applicant_category', $this->applicant_category])
              ->andFilterWhere(['like', 'applicant_category_code', $this->applicant_category_code]);

        return $dataProvider;
    }
}
