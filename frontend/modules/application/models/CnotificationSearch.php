<?php

namespace frontend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\application\models\Cnotification;

/**
 * CnotificationSearch represents the model behind the search form about `app\models\Cnotification`.
 */
class CnotificationSearch extends Cnotification
{
    public function rules()
    {
        return [
            [['cnotification_id'], 'integer'],
            [['subject', 'notification', 'date_created'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Cnotification::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'cnotification_id' => $this->cnotification_id,
            'date_created' => $this->date_created,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'notification', $this->notification]);

        return $dataProvider;
    }
}
