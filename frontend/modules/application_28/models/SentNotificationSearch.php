<?php

namespace frontend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\application\models\SentNotification;

/**
 * SentNotificationSearch represents the model behind the search form about `app\models\SentNotification`.
 */
class SentNotificationSearch extends SentNotification
{
    public function rules()
    {
        return [
            [['sent_notification_id', 'cnotification_id', 'target_group', 'user_sent'], 'integer'],
            [['description', 'date_sent'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SentNotification::find();
        $query->orderBy('date_sent desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'sent_notification_id' => $this->sent_notification_id,
            'cnotification_id' => $this->cnotification_id,
            'target_group' => $this->target_group,
            'user_sent' => $this->user_sent,
            'date_sent' => $this->date_sent,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
