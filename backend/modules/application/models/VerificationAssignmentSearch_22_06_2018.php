<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\VerificationAssignment;

/**
 * VerificationAssignmentSearch represents the model behind the search form about `backend\modules\application\models\VerificationAssignment`.
 */
class VerificationAssignmentSearch extends VerificationAssignment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_assignment_id', 'assignee', 'study_level', 'total_applications', 'assigned_by'], 'integer'],
            [['created_at'], 'safe'],
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
        $query = VerificationAssignment::find();

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
            'verification_assignment_id' => $this->verification_assignment_id,
            'assignee' => $this->assignee,
            'study_level' => $this->study_level,
            'total_applications' => $this->total_applications,
            'assigned_by' => $this->assigned_by,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }    
    
}
