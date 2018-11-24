<?php

namespace frontend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\application\models\ApplicantAttachment;
use backend\modules\application\models\ReattachmentSetting;

/**
 * ApplicantAttachmentSearch represents the model behind the search form about `frontend\modules\application\models\ApplicantAttachment`.
 */
class ApplicantAttachmentSearch extends ApplicantAttachment
{
    public function rules()
    {
        return [
            [['applicant_attachment_id', 'application_id', 'attachment_definition_id', 'verification_status','comment'], 'integer'],
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
    public function searchfile($params,$application_id)
    {
           //find reattachment definition
        $modelall=ReattachmentSetting::findbysql('SELECT group_concat(verification_status) as verification_status ,
            group_concat(comment_id) as comment_id FROM `reattachment_setting` WHERE `is_active`=1')->asArray()->one();
        // print_r($modelall);
        //   exit();
        //  print_r($modelall['verification_status']);
        $verification_status=$modelall['verification_status'];
        $comment_id="";
        if($modelall['comment_id']!=""){
            $comment_id=$modelall['comment_id'];
        }
        // $commentsql='';
        if($comment_id!=""){
            $commentsql=" AND comment IN($comment_id)";
        }
        
           //end 
         $query = ApplicantAttachment::find()->where("application_id='{$application_id}' AND verification_status IN($verification_status) $commentsql ");
         // $query = ApplicantAttachment::find()->where("application_id='{$application_id}'");
        
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
    public function searchAttachments($params,$id)
    {
        $query = ApplicantAttachment::find()
                ->where(['applicant_attachment.application_id'=>$id]);

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
            'comment' => $this->comment,
        ]);

        $query->andFilterWhere(['like', 'attachment_path', $this->attachment_path]);

        return $dataProvider;
    }
}
