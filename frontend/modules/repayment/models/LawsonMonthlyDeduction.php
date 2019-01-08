<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "lawson_monthly_deduction".
 *
 * @property integer $lawson_monthly_deduction_id
 * @property string $ActualBalanceAmount
 * @property string $CheckDate
 * @property string $CheckNumber
 * @property string $DateHired
 * @property string $DeductionAmount
 * @property string $DeductionCode
 * @property string $DeductionDesc
 * @property string $DeptName
 * @property string $FirstName
 * @property string $LastName
 * @property string $MiddleName
 * @property string $NationalId
 * @property string $Sex
 * @property string $VoteName
 * @property string $Votecode
 * @property string $created_at
 */
class LawsonMonthlyDeduction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lawson_monthly_deduction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ActualBalanceAmount', 'DeductionAmount'], 'number'],
            [['CheckDate', 'DateHired', 'created_at','deduction_month','Deptcode'], 'safe'],
            [['CheckNumber', 'DeductionDesc', 'DeptName', 'FirstName', 'LastName', 'MiddleName', 'NationalId', 'VoteName'], 'string', 'max' => 100],
            [['DeductionCode', 'Votecode'], 'string', 'max' => 50],
            [['Sex'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lawson_monthly_deduction_id' => 'Lawson Monthly Deduction ID',
            'ActualBalanceAmount' => 'Actual Balance Amount',
            'CheckDate' => 'Check Date',
            'CheckNumber' => 'Check Number',
            'DateHired' => 'Date Hired',
            'DeductionAmount' => 'Deduction Amount',
            'DeductionCode' => 'Deduction Code',
            'DeductionDesc' => 'Deduction Desc',
            'DeptName' => 'Dept Name',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'MiddleName' => 'Middle Name',
            'NationalId' => 'National ID',
            'Sex' => 'Sex',
            'VoteName' => 'Vote Name',
            'Votecode' => 'Votecode',
            'created_at' => 'Created At',
			'deduction_month'=>'deduction_month',
			'Deptcode'=>'Deptcode',
        ];
    }
	public static function insertGSPPdeductionsDetails($ActualBalanceAmount,$CheckDate,$CheckNumber,$DateHired,$DeductionAmount,$DeductionCode,$DeductionDesc,$DeptName,$FirstName,$LastName,$MiddleName,$NationalId,$Sex,$VoteName,$Votecode,$created_at,$deduction_month,$Deptcode){
	if(self::find()->where(['CheckDate'=>$CheckDate,'CheckNumber'=>$CheckNumber])->count()==0){	
Yii::$app->db->createCommand("INSERT IGNORE INTO lawson_monthly_deduction(ActualBalanceAmount,CheckDate ,CheckNumber,DateHired, 	DeductionAmount,DeductionCode,DeductionDesc,DeptName,FirstName,LastName,MiddleName,NationalId,Sex,VoteName,Votecode,created_at,deduction_month,Deptcode) VALUES('$ActualBalanceAmount','$CheckDate','$CheckNumber','$DateHired','$DeductionAmount','$DeductionCode','$DeductionDesc','$DeptName','$FirstName','$LastName','$MiddleName','$NationalId','$Sex','$VoteName','$Votecode','$created_at','$deduction_month','$Deptcode')")->execute();	
}	
	}
}
