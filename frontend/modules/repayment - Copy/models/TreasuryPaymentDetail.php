<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\repayment\models\LoanRepaymentDetail;
/**
 * This is the model class for table "treasury_payment_detail".
 *
 * @property integer $treasury_payment_detail_id
 * @property integer $treasury_payment_id
 * @property integer $loan_repayment_id
 * @property string $amount
 *
 * @property LoanRepayment $loanRepayment
 * @property TreasuryPayment $treasuryPayment
 */
class TreasuryPaymentDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'treasury_payment_detail';
    }

    /**
     * @inheritdoc
     */
	 public $employer_name;
	 
    public function rules()
    {
        return [
            [['treasury_payment_id', 'loan_repayment_id', 'amount'], 'required'],
			[['employer_name'], 'safe'],
            [['treasury_payment_id', 'loan_repayment_id'], 'integer'],
            [['amount'], 'number'],
            [['loan_repayment_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanRepayment::className(), 'targetAttribute' => ['loan_repayment_id' => 'loan_repayment_id']],
            [['treasury_payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => TreasuryPayment::className(), 'targetAttribute' => ['treasury_payment_id' => 'treasury_payment_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'treasury_payment_detail_id' => 'Treasury Payment Detail ID',
            'treasury_payment_id' => 'Treasury Payment ID',
            'loan_repayment_id' => 'Loan Repayment ID',
            'amount' => 'Amount',
			'employer_name'=>'Employer Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepayment()
    {
        return $this->hasOne(LoanRepayment::className(), ['loan_repayment_id' => 'loan_repayment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreasuryPayment()
    {
        return $this->hasOne(TreasuryPayment::className(), ['treasury_payment_id' => 'treasury_payment_id']);
    }
    public static function insertAllGovernmentEmployersBill($treasury_payment_id){
        $details_loanRepayment = LoanRepayment::findBySql("SELECT loan_repayment.loan_repayment_id AS loan_repayment_id,loan_repayment.amount AS amount FROM loan_repayment INNER JOIN employer ON loan_repayment.employer_id=employer.employer_id "
                . "WHERE  loan_repayment.control_number IS NULL AND  employer.salary_source='1'")->all();
        
		if(count($details_loanRepayment)>0){
		
        foreach ($details_loanRepayment as $loanRepaymentResults) { 
           $loan_repayment_id=$loanRepaymentResults->loan_repayment_id;
           $amount=$loanRepaymentResults->amount;          

        Yii::$app->db->createCommand()
        ->insert('treasury_payment_detail', [
        'treasury_payment_id' =>$treasury_payment_id,
        'loan_repayment_id' =>$loan_repayment_id,
        'amount' =>$amount,   
        ])->execute();
			  
	    LoanRepaymentDetail::updateAll(['treasury_payment_id' => $treasury_payment_id],'loan_repayment_id = "'.$loan_repayment_id.'"');
		
		}
		}
        }
}
