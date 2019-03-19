<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "gepg_bill_processing_setting".
 *
 * @property integer $gepg_bill_processing_setting_id
 * @property string $bill_type
 * @property string $bill_processing_uri
 * @property string $bill_prefix
 * @property string $operation_type
 * @property integer $created_by
 * @property string $created_at
 */
class GepgBillProcessingSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
const RECEIVE_CONTROL_NO = 'RCCNTN';
const RECEIVE_PAYMENT = 'RCPMT';
const RECEIVE_RECONCILIATION_DATA = 'RCRCON';
const RECEIVE_CANCEL_BILL='RCCNCELB';

    public static function tableName()
    {
        return 'gepg_bill_processing_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_type', 'bill_processing_uri', 'bill_prefix', 'operation_type'], 'required', 'on'=>'itemSettingRegister'],
			[['bill_type', 'bill_processing_uri', 'bill_prefix', 'operation_type'], 'required', 'on'=>'itemSettingUpdate'],
            [['created_by'], 'integer'],
            [['created_at','created_by','updated_at','updated_by'], 'safe'],
            [['bill_type'], 'string', 'max' => 50],
			[['bill_type'], 'validateGePGSettingRegister','on'=>'itemSettingRegister'],
			[['bill_type'], 'validateGePGSettingUpdate','on'=>'itemSettingUpdate'],
            [['bill_processing_uri'], 'string', 'max' => 500],
            [['bill_prefix', 'operation_type'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gepg_bill_processing_setting_id' => 'Gepg Bill Processing Setting ID',
            'bill_type' => 'Bill Type',
            'bill_processing_uri' => 'Bill Processing Uri',
            'bill_prefix' => 'Bill Prefix',
            'operation_type' => 'Operation Type',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }
    static function getOperationTypeGePGSetting() {
        return [
            self::RECEIVE_CONTROL_NO => 'Receive Control No',
            self::RECEIVE_PAYMENT => 'Receive Payment',
            self::RECEIVE_RECONCILIATION_DATA => 'Receive Reconciliation Data',
            self::RECEIVE_CANCEL_BILL => 'Receive Cancel Bill',
        ];
    }
    public static function getBillPrefix($billPrefix,$operationType){
        $details=self::findBySql("SELECT  bill_processing_uri "
            . "FROM gepg_bill_processing_setting WHERE  bill_prefix like '$billPrefix%'  AND operation_type='$operationType'")->one();
        return $details;
    }
	public function validateGePGSettingRegister($attribute)
    {

        if (self::findBySql("SELECT * FROM gepg_bill_processing_setting where bill_prefix = '$this->bill_prefix' AND operation_type='$this->operation_type'")
            ->exists()) {
            $this->addError($attribute, 'Item Exist');
            return FALSE;
        }
    
        return true;
    }
    public function validateGePGSettingUpdate($attribute)
    {

            if (self::findBySql("SELECT * FROM gepg_bill_processing_setting where bill_prefix = '$this->bill_prefix' AND operation_type='$this->operation_type' AND gepg_bill_processing_setting_id<>'$this->gepg_bill_processing_setting_id'")
                ->exists()) {
                $this->addError($attribute, 'Item Exist');
                return FALSE;
            }        
        return true;
    }
}
