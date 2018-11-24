<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\DisbursementTaskAssignment;

/**
 * DisbursementTaskAssignmentSearch represents the model behind the search form about `backend\modules\disbursement\models\DisbursementTaskAssignment`.
 */
class DisbursementTaskAssignmentSearch extends DisbursementTaskAssignment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_task_assignment_id', 'disbursement_schedule_id', 'disbursement_structure_id', 'disbursement_task_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
    public function search($params,$id)
    {
        $query = DisbursementTaskAssignment::find()->where(['disbursement_schedule_id'=>$id]);

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
            'disbursement_task_assignment_id' => $this->disbursement_task_assignment_id,
            'disbursement_schedule_id' => $this->disbursement_schedule_id,
            'disbursement_structure_id' => $this->disbursement_structure_id,
            'disbursement_task_id' => $this->disbursement_task_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
          
        ]);

        return $dataProvider;
    }
}
