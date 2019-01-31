<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\Disbursement;

/**
 * DisbursementSearch represents the model behind the search form about `backend\modules\disbursement\models\Disbursement`.
 */
class DisbursementSearch extends Disbursement
{
    /**
     * @inheritdoc
     */
      public $firstName;
      public $lastName;
      public $f4indexno;
      public $academic_year_id;
      public $semester_number;
      public $instalment_definition_id;
    public function rules()
    {
        return [
            [['disbursement_id', 'disbursement_batch_id', 'application_id', 'programme_id', 'loan_item_id', 'status', 'created_by','academic_year_id','semester_number','instalment_definition_id'], 'integer'],
            [['disbursed_amount'], 'number'],
            [['created_at','f4indexno','firstName','lastName'], 'safe'],
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
        $query = Disbursement::find()->where(['disbursement_batch_id' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>FALSE
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->joinwith("application");
         $query->joinwith(["application","application.applicant"]);
         $query->joinwith(["application","application.applicant"]);
        $query->joinwith(["application","application.applicant.user"]);
        $query->andFilterWhere([
            'disbursement_id' => $this->disbursement_id,
            'disbursement_batch_id' => $id,
            'application_id' => $this->application_id,
            'disbursement.programme_id' => $this->programme_id,
            'loan_item_id' => $this->loan_item_id,
            'disbursed_amount' => $this->disbursed_amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);
      $query->andFilterWhere(['like', 'user.firstname', $this->firstName])
         ->andFilterWhere(['like', 'user.surname', $this->lastName])
        ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);
       
        return $dataProvider;
    }
    public function searchmy($params,$id)
    {
        $query = Disbursement::find()->where(['application.application_id' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>FALSE
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
      // grid filtering conditions
        $query->joinwith("application");
         $query->joinwith(["application","application.applicant"]);
         $query->joinwith(["application","application.applicant"]);
        $query->joinwith(["application","application.applicant.user"]);
        $query->andFilterWhere([
            'disbursement_id' => $this->disbursement_id,
            'disbursement_batch_id' =>$this->disbursement_batch_id,
            'application_id' => $this->application_id,
            'disbursement.programme_id' => $this->programme_id,
            'loan_item_id' => $this->loan_item_id,
            'disbursed_amount' => $this->disbursed_amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);
      $query->andFilterWhere(['like', 'user.firstname', $this->firstName])
         ->andFilterWhere(['like', 'user.surname', $this->lastName])
        ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);
       
        return $dataProvider;
    }
      public function searchhli($params,$id)
    {
        $query = Disbursement::find()->where(['disbursement_batch_id' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>FALSE
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->joinwith("application");
         $query->joinwith(["application","application.applicant"]);
         $query->joinwith(["application","application.applicant"]);
        $query->joinwith(["application","application.applicant.user"]);
        $query->joinWith("programme");
        $query->andFilterWhere([
            'disbursement_id' => $this->disbursement_id,
            'disbursement_batch_id' => $id,
            'application_id' => $this->application_id,
            'disbursement.programme_id' => $this->programme_id,
            'loan_item_id' => $this->loan_item_id,
            'disbursed_amount' => $this->disbursed_amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);
      $query->andFilterWhere(['like', 'user.firstname', $this->firstName])
         ->andFilterWhere(['like', 'user.surname', $this->lastName])
        ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
        ->andFilterWhere(['=', 'programme.learning_institution_id',Yii::$app->session["learn_institution_id"]]);
      
        return $dataProvider;
    }
    public function searchDisbursedLoan($params,$id)
    {
        $query = Disbursement::find()
                              ->where(['application.applicant_id'=>$id,'disbursement.status'=>8,'disbursement_batch.is_approved'=>1,'disbursement.disbursed_as'=>1])
                              ->groupBy(['disbursement_batch.academic_year_id','disbursement_batch.semester_number','disbursement_batch.instalment_definition_id'])
                              ->orderBy(['disbursement.disbursement_id'=>SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>FALSE
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
      // grid filtering conditions
        $query->joinwith("application");
         $query->joinwith(["application","application.applicant"]);
         $query->joinwith(["application","application.applicant"]);
        $query->joinwith(["application","application.applicant.user"]);
        $query->joinwith("disbursementBatch");
        $query->andFilterWhere([
            'disbursement_id' => $this->disbursement_id,
            'disbursement_batch_id' =>$this->disbursement_batch_id,
            'application_id' => $this->application_id,
            'disbursement.programme_id' => $this->programme_id,
            'loan_item_id' => $this->loan_item_id,
            'disbursed_amount' => $this->disbursed_amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'disbursement_batch.academic_year_id'=>$this->academic_year_id,
            'disbursement_batch.semester_number'=>$this->semester_number,
            'disbursement_batch.instalment_definition_id'=>$this->instalment_definition_id,
        ]);
      $query->andFilterWhere(['like', 'user.firstname', $this->firstName])
         ->andFilterWhere(['like', 'user.surname', $this->lastName])
        ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);
       
        return $dataProvider;
    }
}
