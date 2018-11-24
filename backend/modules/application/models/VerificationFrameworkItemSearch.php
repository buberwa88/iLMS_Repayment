<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\VerificationFrameworkItem;
use fontend\modules\application\models\AttachmentDefinition;

/**
 * VerificationFrameworkItemSearch represents the model behind the search form about `backend\modules\application\models\VerificationFrameworkItem`.
 */
class VerificationFrameworkItemSearch extends VerificationFrameworkItem
{
    /**
     * @inheritdoc
     */
    public $applicant_attachment_id;
    public $verification_status;
    public $application_id;
    public $attachment_path;
    public function rules()
    {
        return [
            [['verification_framework_item_id', 'verification_framework_id', 'attachment_definition_id', 'created_by', 'is_active'], 'integer'],
            [['attachment_desc', 'verification_prompt', 'created_at'], 'safe'],
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
        $query = VerificationFrameworkItem::find();

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
            'verification_framework_item_id' => $this->verification_framework_item_id,
            'verification_framework_id' => $this->verification_framework_id,
            'attachment_definition_id' => $this->attachment_definition_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'attachment_desc', $this->attachment_desc])
            ->andFilterWhere(['like', 'verification_prompt', $this->verification_prompt]);

        return $dataProvider;
    }
    
    public function searchVerify($params, $condition, $verificationFrameworkID)
    {
        $query = VerificationFrameworkItem::find()
                ->select("verification_framework_item.verification_framework_id AS verification_framework_id,verification_framework_item.attachment_definition_id AS attachment_definition_id,applicant_attachment.application_id AS application_id,applicant_attachment.applicant_attachment_id AS applicant_attachment_id,applicant_attachment.attachment_path AS attachment_path")               
                ->Where(['verification_framework.verification_framework_id'=>$verificationFrameworkID,'applicant_attachment.application_id'=>$condition]);

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
        $query->joinWith("verificationFramework");
        $query->joinWith("attachmentDefinition");
        $query->joinwith(["attachmentDefinition","attachmentDefinition.applicantAttachments"]);
        
        
        $query->andFilterWhere([
            
            'applicant_attachment.applicant_attachment_id' => $this->applicant_attachment_id,
            'applicant_attachment.application_id' => $this->application_id,
            'applicant_attachment.attachment_definition_id' => $this->attachment_definition_id,
            'applicant_attachment.verification_status' => $this->verification_status,
            
            'verification_framework_item_id' => $this->verification_framework_item_id,
            'verification_framework_item.verification_framework_id' => $this->verification_framework_id,
            //'attachment_definition_id' => $this->attachment_definition_id,
            'verification_framework_item.created_at' => $this->created_at,
            'verification_framework_item.created_by' => $this->created_by,
        ]);
     
        $query->andFilterWhere(['like', 'verification_framework_item.attachment_desc', $this->attachment_desc])
            ->andFilterWhere(['like', 'applicant_attachment.attachment_path', $this->attachment_path])    
            ->andFilterWhere(['like', 'verification_framework_item.verification_prompt', $this->verification_prompt]);
        //$query->where($condition);

        return $dataProvider;
    }
}
