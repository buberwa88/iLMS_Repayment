<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\GepgReconMaster;

/**
 * GepgReconMasterSearch represents the model behind the search form about `backend\modules\application\models\GepgReconMaster`.
 */
class GepgReconMasterSearch extends GepgReconMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recon_master_id', 'status'], 'integer'],
            [['recon_date', 'created_at', 'description'], 'safe'],
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
        $query = GepgReconMaster::find()
		                        ->orderBy('recon_master_id DESC');

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
            'recon_master_id' => $this->recon_master_id,
            'status' => $this->status,
        ]);
		
		$query->andFilterWhere(['like', 'recon_date', $this->recon_date])
			->andFilterWhere(['like', 'created_at', $this->created_at])
			->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
