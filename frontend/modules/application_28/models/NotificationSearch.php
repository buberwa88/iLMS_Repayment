<?php

namespace frontend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\application\models\Notification;

/**
 * NotificationSearch represents the model behind the search form about `app\models\Notification`.
 */
class NotificationSearch extends Notification
{
    public function rules()
    {
        return [
            [['notification_id', 'user_id', 'is_read'], 'integer'],
            [['subject', 'notification', 'date_created', 'date_read'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Notification::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'notification_id' => $this->notification_id,
            'user_id' => $this->user_id,
            'date_created' => $this->date_created,
            'is_read' => $this->is_read,
            'date_read' => $this->date_read,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'notification', $this->notification]);

        return $dataProvider;
    }
}
