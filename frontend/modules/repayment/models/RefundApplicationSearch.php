<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\RefundApplication;

/**
 * RefundApplicationSearch represents the model behind the search form about `frontend\modules\repayment\models\RefundApplication`.
 */
class RefundApplicationSearch extends RefundApplication {

    /**
     * @inheritdoc
     */
    public $f4indexno;
    public $firstname;
    public $middlename;
    public $surname;

    public function rules() {
        return [
            [['refund_application_id', 'refund_claimant_id', 'finaccial_year_id', 'academic_year_id', 'current_status', 'refund_verification_framework_id', 'bank_id', 'refund_type_id', 'created_by', 'updated_by', 'is_active', 'submitted'], 'integer'],
            [['application_number', 'trustee_firstname', 'trustee_midlename', 'trustee_surname', 'trustee_sex', 'check_number', 'bank_account_number', 'bank_account_name', 'liquidation_letter_number', 'created_at', 'updated_at', 'f4indexno'], 'safe'],
            [['refund_claimant_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = RefundApplication::find();

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
            'refund_application_id' => $this->refund_application_id,
            'refund_claimant_id' => $this->refund_claimant_id,
            'refund_claimant_amount' => $this->refund_claimant_amount,
            'finaccial_year_id' => $this->finaccial_year_id,
            'academic_year_id' => $this->academic_year_id,
            'current_status' => $this->current_status,
            'refund_verification_framework_id' => $this->refund_verification_framework_id,
            'bank_id' => $this->bank_id,
            'refund_type_id' => $this->refund_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
            'submitted' => $this->submitted,
        ]);

        $query->andFilterWhere(['like', 'application_number', $this->application_number])
                ->andFilterWhere(['like', 'trustee_firstname', $this->trustee_firstname])
                ->andFilterWhere(['like', 'trustee_midlename', $this->trustee_midlename])
                ->andFilterWhere(['like', 'trustee_surname', $this->trustee_surname])
                ->andFilterWhere(['like', 'trustee_sex', $this->trustee_sex])
                ->andFilterWhere(['like', 'check_number', $this->check_number])
                ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
                ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
                ->andFilterWhere(['like', 'liquidation_letter_number', $this->liquidation_letter_number]);

        return $dataProvider;
    }

    public function searchVerification($params, $condition) {
        //$query = RefundApplication::find();

        $loggedin = Yii::$app->user->identity->user_id;
        $query = RefundApplication::find()
                ->select('refund_application.refund_application_id,refund_application.application_number,refund_application.refund_claimant_id, refund_application.refund_type_id,refund_application.current_status,refund_claimant.f4indexno,refund_claimant.firstname,refund_claimant.middlename,refund_claimant.surname,refund_claimant.f4indexno,refund_application.refund_type_id')
                ->where(['refund_application.current_status' => $condition]);

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
        $query->joinwith("refundClaimant");
        $query->andFilterWhere([
            'refund_application_id' => $this->refund_application_id,
            'refund_claimant_id' => $this->refund_claimant_id,
            'refund_claimant_amount' => $this->refund_claimant_amount,
            'finaccial_year_id' => $this->finaccial_year_id,
            'academic_year_id' => $this->academic_year_id,
            'current_status' => $this->current_status,
            'refund_verification_framework_id' => $this->refund_verification_framework_id,
            'bank_id' => $this->bank_id,
            'refund_type_id' => $this->refund_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
            'submitted' => $this->submitted,
        ]);

        $query->andFilterWhere(['like', 'application_number', $this->application_number])
                ->andFilterWhere(['like', 'trustee_firstname', $this->trustee_firstname])
                ->andFilterWhere(['like', 'trustee_midlename', $this->trustee_midlename])
                ->andFilterWhere(['like', 'trustee_surname', $this->trustee_surname])
                ->andFilterWhere(['like', 'trustee_sex', $this->trustee_sex])
                ->andFilterWhere(['like', 'check_number', $this->check_number])
                ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
                ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
                ->andFilterWhere(['like', 'liquidation_letter_number', $this->liquidation_letter_number]);

        return $dataProvider;
    }

    public function searchVerifiedRefundAppl($params, $currentLevel) {

        $query = RefundApplication::find()
                ->select('refund_application.refund_application_id,refund_application.application_number,refund_application.refund_claimant_id, refund_application.refund_type_id,refund_application.current_status,refund_claimant.f4indexno,refund_claimant.firstname,refund_claimant.middlename,refund_claimant.surname,refund_claimant.f4indexno,refund_application.refund_type_id')
                ->where(['refund_application.current_level' => $currentLevel]);

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
        $query->joinwith("refundClaimant");
        $query->andFilterWhere([
            'refund_application_id' => $this->refund_application_id,
            'refund_claimant_id' => $this->refund_claimant_id,
            'refund_claimant_amount' => $this->refund_claimant_amount,
            'finaccial_year_id' => $this->finaccial_year_id,
            'academic_year_id' => $this->academic_year_id,
            'current_status' => $this->current_status,
            'refund_verification_framework_id' => $this->refund_verification_framework_id,
            'bank_id' => $this->bank_id,
            'refund_type_id' => $this->refund_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
            'submitted' => $this->submitted,
        ]);

        $query->andFilterWhere(['like', 'application_number', $this->application_number])
                ->andFilterWhere(['like', 'trustee_firstname', $this->trustee_firstname])
                ->andFilterWhere(['like', 'trustee_midlename', $this->trustee_midlename])
                ->andFilterWhere(['like', 'trustee_surname', $this->trustee_surname])
                ->andFilterWhere(['like', 'trustee_sex', $this->trustee_sex])
                ->andFilterWhere(['like', 'check_number', $this->check_number])
                ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
                ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
                ->andFilterWhere(['like', 'liquidation_letter_number', $this->liquidation_letter_number]);

        return $dataProvider;
    }

    public function searchVerifiedRefundWaitingLetter($params, $currentLevel, $codeResponseID) {
        //$codeResponseID=[1,3,5];
        //print_r($codeResponseID);exit;
        $query = RefundApplication::find()
                ->select('refund_application.refund_application_id,refund_application.application_number,refund_application.refund_claimant_id, refund_application.refund_type_id,refund_application.current_status,refund_claimant.f4indexno,refund_claimant.firstname,refund_claimant.middlename,refund_claimant.surname,refund_claimant.f4indexno,refund_application.refund_type_id')
                ->where(['refund_application.current_level' => $currentLevel, 'refund_application.verification_response' => $codeResponseID]);

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
        $query->joinwith("refundClaimant");
        $query->andFilterWhere([
            'refund_application_id' => $this->refund_application_id,
            'refund_claimant_id' => $this->refund_claimant_id,
            'refund_claimant_amount' => $this->refund_claimant_amount,
            'finaccial_year_id' => $this->finaccial_year_id,
            'academic_year_id' => $this->academic_year_id,
            'current_status' => $this->current_status,
            'refund_verification_framework_id' => $this->refund_verification_framework_id,
            'bank_id' => $this->bank_id,
            'refund_type_id' => $this->refund_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
            'submitted' => $this->submitted,
        ]);

        $query->andFilterWhere(['like', 'application_number', $this->application_number])
                ->andFilterWhere(['like', 'trustee_firstname', $this->trustee_firstname])
                ->andFilterWhere(['like', 'trustee_midlename', $this->trustee_midlename])
                ->andFilterWhere(['like', 'trustee_surname', $this->trustee_surname])
                ->andFilterWhere(['like', 'trustee_sex', $this->trustee_sex])
                ->andFilterWhere(['like', 'check_number', $this->check_number])
                ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
                ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
                ->andFilterWhere(['like', 'liquidation_letter_number', $this->liquidation_letter_number]);

        return $dataProvider;
    }

    public function searchVerifiedRefundWaitingPayment($params, $currentLevel, $PayListStatus) {

        $query = RefundApplication::find()
                ->select('refund_application.refund_claimant_amount,refund_application.refund_application_id,refund_application.application_number,refund_application.refund_claimant_id, refund_application.refund_type_id,refund_application.current_status,refund_claimant.f4indexno,refund_claimant.firstname,refund_claimant.middlename,refund_claimant.surname,refund_claimant.f4indexno,refund_application.refund_type_id')
                ->where(['refund_application.current_level' => $currentLevel, 'refund_application.current_status' => $PayListStatus]);

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
        $query->joinwith("refundClaimant");
        $query->andFilterWhere([
            'refund_application_id' => $this->refund_application_id,
            'refund_claimant_id' => $this->refund_claimant_id,
            'refund_claimant_amount' => $this->refund_claimant_amount,
            'finaccial_year_id' => $this->finaccial_year_id,
            'academic_year_id' => $this->academic_year_id,
            'current_status' => $this->current_status,
            'refund_verification_framework_id' => $this->refund_verification_framework_id,
            'bank_id' => $this->bank_id,
            'refund_type_id' => $this->refund_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
            'submitted' => $this->submitted,
        ]);

        $query->andFilterWhere(['like', 'application_number', $this->application_number])
                ->andFilterWhere(['like', 'trustee_firstname', $this->trustee_firstname])
                ->andFilterWhere(['like', 'trustee_midlename', $this->trustee_midlename])
                ->andFilterWhere(['like', 'trustee_surname', $this->trustee_surname])
                ->andFilterWhere(['like', 'trustee_sex', $this->trustee_sex])
                ->andFilterWhere(['like', 'check_number', $this->check_number])
                ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
                ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
                ->andFilterWhere(['like', 'liquidation_letter_number', $this->liquidation_letter_number]);

        return $dataProvider;
    }

    public function searchVerifiedRefundPaid($params, $PayListStatus) {

        $query = RefundApplication::find()
                ->select('refund_application.refund_claimant_amount,refund_application.refund_application_id,refund_application.application_number,refund_application.refund_claimant_id, refund_application.refund_type_id,refund_application.current_status,refund_claimant.f4indexno,refund_claimant.firstname,refund_claimant.middlename,refund_claimant.surname,refund_claimant.f4indexno,refund_application.refund_type_id')
                ->where(['refund_application.current_status' => $PayListStatus]);

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
        $query->joinwith("refundClaimant");
        $query->andFilterWhere([
            'refund_application_id' => $this->refund_application_id,
            'refund_claimant_id' => $this->refund_claimant_id,
            'refund_claimant_amount' => $this->refund_claimant_amount,
            'finaccial_year_id' => $this->finaccial_year_id,
            'academic_year_id' => $this->academic_year_id,
            'current_status' => $this->current_status,
            'refund_verification_framework_id' => $this->refund_verification_framework_id,
            'bank_id' => $this->bank_id,
            'refund_type_id' => $this->refund_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
            'submitted' => $this->submitted,
        ]);

        $query->andFilterWhere(['like', 'application_number', $this->application_number])
                ->andFilterWhere(['like', 'trustee_firstname', $this->trustee_firstname])
                ->andFilterWhere(['like', 'trustee_midlename', $this->trustee_midlename])
                ->andFilterWhere(['like', 'trustee_surname', $this->trustee_surname])
                ->andFilterWhere(['like', 'trustee_sex', $this->trustee_sex])
                ->andFilterWhere(['like', 'check_number', $this->check_number])
                ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
                ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
                ->andFilterWhere(['like', 'liquidation_letter_number', $this->liquidation_letter_number]);

        return $dataProvider;
    }

    function searchPendingRefunds() {
        $query = RefundApplication::find()
                ->where(['current_status' => RefundApplication::PAY_LIST_WAITING_QUEUE]);

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
        $query->joinwith("refundClaimant");
        $query->andFilterWhere([
            'refund_application_id' => $this->refund_application_id,
            'refund_claimant_id' => $this->refund_claimant_id,
            'finaccial_year_id' => $this->finaccial_year_id,
            'academic_year_id' => $this->academic_year_id,
            'refund_verification_framework_id' => $this->refund_verification_framework_id,
            'refund_type_id' => $this->refund_type_id,
            'is_active' => $this->is_active,
            'submitted' => $this->submitted,
        ]);

        $query->andFilterWhere(['like', 'application_number', $this->application_number])
                ->andFilterWhere(['like', 'refund_claimant_amount', $this->refund_claimant_amount])
                ->andFilterWhere(['like', 'trustee_firstname', $this->trustee_firstname])
                ->andFilterWhere(['like', 'trustee_midlename', $this->trustee_midlename])
                ->andFilterWhere(['like', 'trustee_surname', $this->trustee_surname])
                ->andFilterWhere(['like', 'trustee_sex', $this->trustee_sex])
                ->andFilterWhere(['like', 'check_number', $this->check_number])
                ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
                ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name]);

        return $dataProvider;
    }
	function searchPaidRefunds() {
        $query = RefundApplication::find()
                ->where(['current_status' => RefundApplication::PAID_APPLICATION]);

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
        $query->joinwith("refundClaimant");
        $query->andFilterWhere([
            'refund_application_id' => $this->refund_application_id,
            'refund_claimant_id' => $this->refund_claimant_id,
            'finaccial_year_id' => $this->finaccial_year_id,
            'academic_year_id' => $this->academic_year_id,
            'refund_verification_framework_id' => $this->refund_verification_framework_id,
            'refund_type_id' => $this->refund_type_id,
            'is_active' => $this->is_active,
            'submitted' => $this->submitted,
        ]);

        $query->andFilterWhere(['like', 'application_number', $this->application_number])
                ->andFilterWhere(['like', 'refund_claimant_amount', $this->refund_claimant_amount])
                ->andFilterWhere(['like', 'trustee_firstname', $this->trustee_firstname])
                ->andFilterWhere(['like', 'trustee_midlename', $this->trustee_midlename])
                ->andFilterWhere(['like', 'trustee_surname', $this->trustee_surname])
                ->andFilterWhere(['like', 'trustee_sex', $this->trustee_sex])
                ->andFilterWhere(['like', 'check_number', $this->check_number])
                ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
                ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name]);

        return $dataProvider;
    }

}
