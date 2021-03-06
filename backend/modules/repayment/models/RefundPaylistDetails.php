<?php

namespace backend\modules\repayment\models;

use yii\data\ActiveDataProvider;
use Yii;

/**
 * This is the model class for table "refund_paylist_details".
 *
 * @property integer $refund_paylist_details_id
 * @property integer $refund_paylist_id
 * @property string $refund_application_reference_number
 * @property integer $refund_claimant_id
 * @property string $claimant_f4indexno
 * @property string $claimant_name
 * @property double $refund_claimant_amount
 * @property integer $phone_number
 * @property integer $email_address
 * @property integer $academic_year_id
 * @property integer $financial_year_id
 * @property integer $status
 */
class RefundPaylistDetails extends \yii\db\ActiveRecord {

    const STATUS_CREATED = 1;
    const STATUS_VERIFIED = 2;
    const STATUS_APPROVED = 3;
    const STATUS_PAID = 4;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'refund_paylist_details';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['refund_paylist_id', 'refund_application_reference_number', 'refund_claimant_id', 'refund_application_id', 'claimant_name', 'refund_claimant_amount', 'academic_year_id', 'financial_year_id', 'status', 'payment_bank_account_name', 'payment_bank_account_number', 'payment_bank_name'], 'required'],
            [['refund_paylist_id', 'refund_claimant_id', 'academic_year_id', 'financial_year_id', 'status'], 'integer'],
            [['refund_claimant_amount'], 'number'],
            [['refund_claimant_amount'], 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['refund_application_reference_number'], 'string', 'max' => 100],
            [['claimant_f4indexno'], 'string', 'max' => 30],
            [['phone_number'], 'string', 'max' => 20],
            [['claimant_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'refund_paylist_details_id' => 'Refund Paylist Details ID',
            'refund_paylist_id' => 'Paylist ID',
            'refund_application_reference_number' => 'Reference Number',
            'refund_claimant_id' => 'Claimant',
            'refund_application_id' => 'Refund Application ID',
            'claimant_f4indexno' => 'F4indexno',
            'claimant_name' => 'Claimant Name',
            'refund_claimant_amount' => 'Refund Amount',
            'phone_number' => 'Phone Number',
            'email_address' => 'Email Address',
            'academic_year_id' => 'Academic Year ID',
            'financial_year_id' => 'Financial Year ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaylist() {
        return $this->hasOne(RefundPaylist::className(), ['refund_paylist_id' => 'refund_paylist_id']);
    }

    function getStatusOptions() {
        return [
            self::STATUS_CREATED => 'Created',
            self::STATUS_VERIFIED => 'Verified',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_PAID => 'Paid'
        ];
    }

    function getStatusName() {
        $status = $this->getStatusOptions();
        if (isset($status[$this->status])) {
            return $status[$this->status];
        }
        return NULL;
    }

    function getPlayListDetails($refund_paylist_id) {
        $query = RefundPaylistDetails::find()->where(['refund_paylist_id'=>$refund_paylist_id]);

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere([
            'refund_paylist_id' => $this->refund_paylist_id,
            'status' => $this->status,
            'refund_claimant_id' => $this->refund_claimant_id,
            'refund_application_id' => $this->refund_application_id
        ]);

        $query->andFilterWhere(['like', 'claimant_f4indexno', $this->claimant_f4indexno])
                ->andFilterWhere(['like', 'refund_claimant_amount', $this->refund_claimant_amount])
                ->andFilterWhere(['like', 'academic_year_id', $this->academic_year_id]);

        return $dataProvider;
    }

    static function getPayListTotalAmountById($paylist_id) {
        $sql = "SELECT SUM(refund_claimant_amount) AS refund_claimant_amount 
                FROM refund_paylist_details WHERE refund_paylist_id=:id";
        $data = RefundPaylistDetails::findBySql($sql, [':id' => $paylist_id])->one();
        if ($data) {
            return $data->refund_claimant_amount;
        }
        return 0;
    }

    public function searchPaidRefunds($params) {
        $query = RefundPaylistDetails::find()
                ->where(['status' => self::STATUS_PAID]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->orderBy('refund_paylist_id DESC');
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'financial_year_id' => $this->financial_year_id,
        ]);

        $query->andFilterWhere(['like', 'refund_application_reference_number', $this->refund_application_reference_number])
                ->andFilterWhere(['like', 'phone_number', $this->phone_number])
                ->andfilterWhere(['like', 'refund_application_id', $this->refund_application_id])
                ->andFilterWhere(['like', 'claimant_name', $this->claimant_name]);

        return $dataProvider;
    }

    public static function updatePaylistDetails($currentStatus,$refund_paylist_id) {
        self::updateAll(['status' => $currentStatus], 'refund_paylist_id ="' . $refund_paylist_id . '"');
    }

}
