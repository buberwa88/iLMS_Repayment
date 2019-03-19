<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "system_setting".
 *
 * @property integer $system_setting_id
 * @property string $setting_name
 * @property string $setting_code
 * @property string $setting_value
 * @property string $value_data_type
 * @property integer $is_active
 */
class SystemSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const Loan_Repayment_Grace_Period='LRGPD';
    const Employee_Monthly_Loan_Repayment='EMLRP';
    const Self_Employed_Monthly_Loan_Repayment='SEMLRA';
    const Average_number_of_days_per_year='TNDY';

    public static function tableName()
    {
        return 'system_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_name', 'setting_code','value_data_type','setting_value'], 'required','on'=>'Itemregister'],
            [['setting_name', 'setting_code','value_data_type','setting_value'], 'required','on'=>'Itemupdate'],
            [['item_formula','graduated_from','graduated_to'], 'safe'],
            [['value_data_type'], 'string'],
            [['setting_value'], 'number'],
            [['is_active'], 'integer'],
            [['setting_code'], 'validateSystemCodeRegister','on'=>'Itemregister'],
            [['setting_value'], 'validatePercentItemrate'],
            //[['setting_code'], 'validateGraduatedFromCheckNew','on'=>'Itemregister'],
            [['setting_code'], 'validateGraduatedFromCheckNew'],
            [['setting_code'], 'validateSystemCodeUpdate','on'=>'Itemupdate'],
            [['setting_code'], 'validateGraduatedToCheck','on'=>'Itemupdate'],
            [['setting_name'], 'string', 'max' => 100],
            [['setting_code'], 'string', 'max' => 20],
            [['setting_value'], 'string', 'max' => 50],
            //[['setting_code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'system_setting_id' => 'System Setting ID',
            'setting_name' => 'Setting Name',
            'setting_code' => 'Setting Code',
            'setting_value' => 'Rate',
            'value_data_type' => 'Rate Type',
            'is_active' => 'Is Active',
            'item_formula'=>'item_formula',
			'graduated_from'=>'Graduated From',
			'graduated_to'=>'Graduated To',
        ];
    }
    static function getItemListCode() {
        return [
            self::Loan_Repayment_Grace_Period=>'LRGPD',
            self::Employee_Monthly_Loan_Repayment=>'EMLRP',
            self::Self_Employed_Monthly_Loan_Repayment=>'SEMLRA',
            self::Average_number_of_days_per_year=>'TNDY',
        ];
    }
    public function validateSystemCodeRegister($attribute)
    {
        if (self::findBySql("SELECT * FROM system_setting where setting_code = '$this->setting_code' AND is_active='1'")
            ->exists()) {
            $this->addError($attribute, 'Item Exist');
            return FALSE;
        }
        return true;
    }
    public function validateSystemCodeUpdate($attribute)
    {
        if (self::findBySql("SELECT * FROM system_setting where setting_code = '$this->setting_code' AND is_active='1' AND system_setting_id<>'$this->system_setting_id'")
            ->exists()) {
            $this->addError($attribute, 'Item Exist');
            return FALSE;
        }
        return true;
    }
    public function validateGraduatedToCheck($attribute)
    {
        if ($this->is_active == 0 && $this->graduated_to =='' && $this->graduated_from !='') {
            $this->addError($attribute, 'Required Graduated To');
            return FALSE;
        }
        return true;
    }
    public function validateGraduatedFromCheckNew($attribute)
    {
        if ($this->setting_code =='LRGPD' && $this->graduated_from =='') {
            $this->addError($attribute, 'Required Graduated From');
            return FALSE;
        }
        return true;
    }


    public function validatePercentItemrate($attribute) {
        if($this->value_data_type=='PERCENT') {
            if ($this->setting_value > 100 || $this->setting_value < 0) {
                $this->addError($attribute, 'Invalid Rate');
                return FALSE;
            }
        }
        if($this->value_data_type=='DAY') {
            if ($this->setting_value > 366 || $this->setting_value < 0) {
                $this->addError($attribute, 'Invalid Rate');
                return FALSE;
            }
        }
        if($this->value_data_type=='AMOUNT') {
            if ($this->setting_value < 0) {
                $this->addError($attribute, 'Invalid Rate');
                return FALSE;
            }
        }
        return true;
    }

    public static function checkItemUsed(){
        $countExist=0;
        $loanRepaymentDetails = \frontend\modules\repayment\models\LoanRepaymentDetail::findBySql("SELECT * FROM loan_repayment_detail")->count();
        if($loanRepaymentDetails > 0){
            $countExist=1;
        }
        return $countExist;
    }
}
