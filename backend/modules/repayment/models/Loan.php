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
	
}
