<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "gepg_lawson".
 *
 * @property integer $gepg_lawson_id
 * @property string $bill_number
 * @property string $amount
 * @property string $control_number
 * @property string $control_number_date
 * @property string $deduction_month
 * @property integer $status
 * @property string $gepg_date
 */
class GepgLawson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const GSPP_DEDUCTION_CODE=465;
    public static function tableName()
    {
        return 'gepg_lawson';
    }

    /**
     * @inheritdoc
     */
	 public $name;
	 public $phone_number;
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['control_number_date', 'deduction_month', 'gepg_date','check_date','gspp_totalAmount','amount_status','gspp_detailAmount','totalEmployees','gsppContrlnAcknowledge','name','phone_number'], 'safe'],
            [['status'], 'integer'],
            [['bill_number', 'control_number'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gepg_lawson_id' => 'Gepg Lawson ID',
            'bill_number' => 'Bill Number',
            'amount' => 'Amount',
            'control_number' => 'Control Number',
            'control_number_date' => 'Control Number Date',
            'deduction_month' => 'Deduction Month',
            'status' => 'Status',
            'gepg_date' => 'Gepg Date',
			'check_date'=>'check_date',
			'gspp_totalAmount'=>'gspp_totalAmount',
			'amount_status'=>'amount_status',
			'gspp_detailAmount'=>'gspp_detailAmount',
            'totalEmployees'=>'totalEmployees',
			'gsppContrlnAcknowledge'=>'gsppContrlnAcknowledge',
        ];
    }
	public static function getBillTreasuryPerYear($year){
	return self::findBySql("SELECT * FROM gepg_lawson WHERE  control_number_date LIKE '$year%'")->count();
}
    public static function confirmControlNumberSentToGSPP($controlNumber,$output){
        $gsppAcknDate=date("Y-m-d H:i:s");
        $results=strpos($output,'RS');
        if($results > 0) {
            self::updateAll(['status' => 2,'gsppContrlnAcknowledge'=>$output,'gsppAcknDate'=>$gsppAcknDate], 'control_number="' . $controlNumber . '"');
        }else{
            self::updateAll(['gsppContrlnAcknowledge'=>$output,'gsppAcknDate'=>$gsppAcknDate], 'control_number="' . $controlNumber . '"');
        }
    }
}
