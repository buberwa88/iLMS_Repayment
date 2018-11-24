<?php

namespace frontend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\application\models\ApplicantAttachment;

/**
 * ApplicantAttachmentSearch represents the model behind the search form about `frontend\modules\application\models\ApplicantAttachment`.
 */
class ApplicantAttachmentSearch extends ApplicantAttachment
{
    public function rules()
    {
        return [
            [['applicant_attachment_id', 'application_id', 'attachment_definition_id', 'verification_status'], 'integer'],
            [['attachment_path'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ApplicantAttachment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'applicant_attachment_id' => $this->applicant_attachment_id,
            'application_id' => $this->application_id,
            'attachment_definition_id' => $this->attachment_definition_id,
            'verification_status' => $this->verification_status,
        ]);

        $query->andFilterWhere(['like', 'attachment_path', $this->attachment_path]);

        return $dataProvider;
    }
}
