<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\Allocation;

/**
 * AllocationSearch represents the model behind the search form about `backend\modules\allocation\models\Allocation`.
 */
class AllocationSearch extends Allocation
{
    /**
     * @inheritdoc
     */
      public $firstName;
      public $surName;
      public $f4indexno;
      public $allocatedate;
      public $academic_year_id;
    public function rules()
    {
        return [
            [['allocation_id', 'allocation_batch_id', 'application_id', 'loan_item_id', 'is_canceled','academic_year_id'], 'integer'],
            [['allocated_amount'], 'number'],
            [['cancel_comment','f4indexno','firstName','surName','allocatedate'], 'safe'],
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
        $query = Allocation::find()->where(["allocation_batch_id"=>$id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>FALSE,
//             'sort' => ['attributes' => [
//                   
//                   //related columns
//                   'firstName' => [
//                        'asc' => ['user.firstname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                   'surName' => [
//                       'asc' => ['user.surname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                  'f4indexno' => [
//                       'asc' => ['applicant.f4indexno' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                  'surName' => [
//                       'asc' => ['user.surname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                  'surName' => [
//                       'asc' => ['user.surname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//              ],],
    ]);
      

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
         $query->joinWith("application");
         $query->joinwith(["application","application.applicant"]);
         $query->joinwith(["application","application.applicant.user"]);
         $query->andFilterWhere([
            'allocation_id' => $this->allocation_id,
            'allocation_batch_id' => $this->allocation_batch_id,
            'application_id' => $this->application_id,
            'loan_item_id' => $this->loan_item_id,
            'allocated_amount' => $this->allocated_amount,
            'is_canceled' => $this->is_canceled,
        ]);
 $query->andFilterWhere(['like', 'user.firstname', $this->firstName])
         ->andFilterWhere(['like', 'user.surname', $this->surName])
        ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
         ->andFilterWhere(['like', 'cancel_comment', $this->cancel_comment]);
       return $dataProvider;
    }
    public function searchmyallocation($params,$id)
    {
        $query = Allocation::find()->where(["application.application_id"=>$id]);

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
         $query->joinWith("application");
         $query->joinwith(["application","application.applicant"]);
         $query->joinwith(["application","application.applicant.user"]);
         $query->andFilterWhere([
            'allocation_id' => $this->allocation_id,
            'allocation_batch_id' => $this->allocation_batch_id,
            'application_id' => $this->application_id,
            'loan_item_id' => $this->loan_item_id,
            'allocated_amount' => $this->allocated_amount,
            'is_canceled' => $this->is_canceled,
        ]);
 $query->andFilterWhere(['like', 'user.firstname', $this->firstName])
         ->andFilterWhere(['like', 'user.surname', $this->surName])
        ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
         ->andFilterWhere(['like', 'cancel_comment', $this->cancel_comment]);
       return $dataProvider;
    }
      public function searchsummary($params,$id)
    {
        $query = Allocation::find()->groupBy("application_id")->where(["allocation_batch_id"=>$id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>FALSE,
//             'sort' => ['attributes' => [
//                   
//                   //related columns
//                   'firstName' => [
//                        'asc' => ['user.firstname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                   'surName' => [
//                       'asc' => ['user.surname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                  'f4indexno' => [
//                       'asc' => ['applicant.f4indexno' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                  'surName' => [
//                       'asc' => ['user.surname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                  'surName' => [
//                       'asc' => ['user.surname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//              ],],
    ]);
      

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
         $query->joinWith("application");
         $query->joinwith(["application","application.applicant"]);
         $query->joinwith(["application","application.applicant.user"]);
         $query->andFilterWhere([
            'allocation_id' => $this->allocation_id,
            'allocation_batch_id' => $this->allocation_batch_id,
            'application_id' => $this->application_id,
            'loan_item_id' => $this->loan_item_id,
            'allocated_amount' => $this->allocated_amount,
            'is_canceled' => $this->is_canceled,
        ]);
 $query->andFilterWhere(['like', 'user.firstname', $this->firstName])
         ->andFilterWhere(['like', 'user.surname', $this->surName])
        ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
         ->andFilterWhere(['like', 'cancel_comment', $this->cancel_comment]);
       return $dataProvider;
    }
   public function searchloaniteam($params,$model)
    {
        $query = Allocation::find()->where(["allocation_batch_id"=>$model->allocation_batch_id,'application_id'=>$model->application_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>FALSE,
//             'sort' => ['attributes' => [
//                   
//                   //related columns
//                   'firstName' => [
//                        'asc' => ['user.firstname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                   'surName' => [
//                       'asc' => ['user.surname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                  'f4indexno' => [
//                       'asc' => ['applicant.f4indexno' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                  'surName' => [
//                       'asc' => ['user.surname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//                  'surName' => [
//                       'asc' => ['user.surname' => SORT_ASC],
//                        'default' => SORT_ASC
//                   ],
//              ],],
    ]);
      

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
//         $query->joinWith("application");
//         $query->joinwith(["application","application.applicant"]);
//         $query->joinwith(["application","application.applicant.user"]);
         $query->andFilterWhere([
            'allocation_id' => $this->allocation_id,
            'allocation_batch_id' => $this->allocation_batch_id,
            'application_id' => $this->application_id,
            'loan_item_id' => $this->loan_item_id,
            'allocated_amount' => $this->allocated_amount,
            'is_canceled' => $this->is_canceled,
        ]);
// $query->andFilterWhere(['like', 'user.firstname', $this->firstName])
//         ->andFilterWhere(['like', 'user.surname', $this->surName])
//        ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
//         ->andFilterWhere(['like', 'cancel_comment', $this->cancel_comment]);
       return $dataProvider;
    }
    public function searchAllocatedLoan($params,$id)
    {
        $query = Allocation::find()
                              //->select('application.assignee')
                              ->where(['application.applicant_id'=>$id,'allocation.is_canceled'=>0,'allocation_batch.is_approved'=>'1','allocation_batch.is_canceled'=>'0'])
                              //->groupBy(['allocation.academic_year_id'])
                              ->groupBy(['allocation_batch.academic_year_id'])
                              ->orderBy(['allocation.allocation_id'=>SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>FALSE,
    ]);
      

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
         $query->joinWith("application");
         $query->joinwith(["application","application.applicant"]);
         $query->joinwith(["application","application.applicant.user"]);
         $query->joinWith("allocationBatch");
         $query->andFilterWhere([
            'allocation_id' => $this->allocation_id,
            'allocation_batch_id' => $this->allocation_batch_id,
            'application_id' => $this->application_id,
            'loan_item_id' => $this->loan_item_id,
            'allocated_amount' => $this->allocated_amount,
            'is_canceled' => $this->is_canceled,
            'allocation_batch.academic_year_id'=>$this->academic_year_id, 
        ]);
 $query->andFilterWhere(['like', 'user.firstname', $this->firstName])
         ->andFilterWhere(['like', 'user.surname', $this->surName])
        ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
         ->andFilterWhere(['like', 'cancel_comment', $this->cancel_comment]);
       return $dataProvider;
    }
	public function searchAllocatedLoanHelpDesk($params,$application_id)
    {
        $query = Allocation::find()
                              //->select('application.assignee')
                              ->where(['allocation.application_id'=>$application_id,'allocation.is_canceled'=>0,'allocation_batch.is_approved'=>'1','allocation_batch.is_canceled'=>'0'])
                              //->groupBy(['allocation.academic_year_id'])
                              ->groupBy(['allocation_batch.allocation_batch_id'])
                              ->orderBy(['allocation_batch.allocation_batch_id'=>SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>FALSE,
    ]);
      

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
         $query->joinWith("application");
         $query->joinwith(["application","application.applicant"]);
         $query->joinwith(["application","application.applicant.user"]);
         $query->joinWith("allocationBatch");
         $query->andFilterWhere([
            'allocation_id' => $this->allocation_id,
            'allocation_batch_id' => $this->allocation_batch_id,
            'application_id' => $this->application_id,
            'loan_item_id' => $this->loan_item_id,
            'allocated_amount' => $this->allocated_amount,
            'is_canceled' => $this->is_canceled, 
        ]);
 $query->andFilterWhere(['like', 'user.firstname', $this->firstName])
         ->andFilterWhere(['like', 'user.surname', $this->surName])
        ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
         ->andFilterWhere(['like', 'cancel_comment', $this->cancel_comment]);
       return $dataProvider;
    }
}
