<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "loan".
 *
 * @property integer $loan_id
 * @property integer $applicant_id
 * @property string $loan_number
 * @property integer $loan_repayment_item_id
 * @property integer $academic_year_id
 * @property string $amount
 * @property string $vrf_accumulated
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_full_paid
 * @property integer $loan_given_to
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Applicant $applicant
 */
class Loan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loan';
    }

    /**
     * @inheritdoc
     */
	const LOAN_NOT_FULL_PAID = 0;
    const LOAN_FULL_PAID = 1;
	
    public function rules()
    {
        return [
            //[['applicant_id', 'loan_number', 'amount', 'loan_given_to', 'created_by'], 'required'],
            [['applicant_id', 'loan_repayment_item_id', 'academic_year_id', 'is_full_paid', 'loan_given_to', 'created_by', 'updated_by'], 'integer'],
            [['amount', 'vrf_accumulated'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['loan_number'], 'string', 'max' => 50],
			[['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            //[['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loan_id' => 'Loan ID',
            'applicant_id' => 'Applicant ID',
            'loan_number' => 'Loan Number',
            'loan_repayment_item_id' => 'Loan Repayment Item ID',
            'academic_year_id' => 'Academic Year ID',
            'amount' => 'Amount',
            'vrf_accumulated' => 'Vrf Accumulated',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_full_paid' => 'Is Full Paid',
            'loan_given_to' => 'Loan Given To',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant()
    {
     return $this->hasOne(\frontend\modules\application\models\Applicant::className(), ['applicant_id' => 'applicant_id']);
    }

    public static function insertLoanGeneral($applicantID,$application_id,$loan_repayment_item_id,$academicYearID,$amount,$loan_given_to,$loggedin) {
        $is_full_paid=0;
        $totalCount=self::findBySql("SELECT  loan.* FROM  loan WHERE  applicant_id='$applicantID' AND loan_number='$application_id' AND loan_repayment_item_id='$loan_repayment_item_id' AND loan_given_to='$loan_given_to'")->count();
        if($totalCount ==0){
            $created_at=date("Y-m-d H:i:s");
            Yii::$app->db->createCommand("INSERT IGNORE INTO  loan(applicant_id,loan_number,loan_repayment_item_id,academic_year_id,amount,created_at,updated_at,is_full_paid,loan_given_to,created_by,updated_by) VALUES('$applicantID','$application_id','$loan_repayment_item_id','$academicYearID','$amount','$created_at','$created_at','$is_full_paid','$loan_given_to','$loggedin','$loggedin')")->execute();
        }
    }
    static function hasUnCompletedLoan($applicant_id) {
        return self::find()->where(['applicant_id' => $applicant_id, 'loan_given_to' => \frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE, 'is_full_paid' => self::LOAN_NOT_FULL_PAID])->exists();
    }

    static function hasLoan($applicant_id) {
        return self::find()->where(['applicant_id' => $applicant_id])->exists();
    }
	
}
