<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'security_question_id', 'is_default_password', 'status', 'login_counts', 'activation_email_sent', 'email_verified', 'created_at', 'updated_at', 'created_by', 'login_type'], 'integer'],
            [['firstname', 'middlename', 'surname', 'sex', 'username', 'password_hash', 'security_answer', 'email_address', 'passport_photo', 'phone_number', 'status_comment', 'last_login_date', 'date_password_changed', 'auth_key', 'password_reset_token'], 'safe'],
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
        $query = User::find();

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
            'user_id' => $this->user_id,
            'security_question_id' => $this->security_question_id,
            'is_default_password' => $this->is_default_password,
            'status' => $this->status,
            'login_counts' => $this->login_counts,
            'last_login_date' => $this->last_login_date,
            'date_password_changed' => $this->date_password_changed,
            'activation_email_sent' => $this->activation_email_sent,
            'email_verified' => $this->email_verified,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'login_type' => $this->login_type,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'security_answer', $this->security_answer])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'passport_photo', $this->passport_photo])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'status_comment', $this->status_comment])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token]);

        return $dataProvider;
    }
}
