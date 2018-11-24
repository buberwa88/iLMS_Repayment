<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "gepg_payment_reconciliation".
 *
 * @property integer $id
 * @property integer $trans_id
 * @property string $trans_date
 * @property string $bill_number
 * @property string $control_number
 * @property string $receipt_number
 * @property string $paid_amount
 * @property string $payment_channel
 * @property string $account_number
 * @property string $Remarks
 * @property string $date_created
 */
class GepgPaymentReconciliation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gepg_payment_reconciliation';
    }

    /**
     * @inheritdoc
     */
	 public $f4indexno;
	 public $bill_amount;
	 public $controlNumberFile;
	 public $file;
    public function rules()
    {
        return [
            [['trans_id'], 'integer'],
            [['trans_date', 'date_created'], 'safe'],
			[['trans_date','receipt_number','paid_amount'], 'required','on'=>'upload_payment_recon'],
            [['paid_amount'], 'number'],
            [['payment_channel'], 'string'],
            [['bill_number', 'control_number', 'receipt_number', 'account_number'], 'string', 'max' => 500],
			[['controlNumberFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls', 'on' => 'upload_payment_recon2'],
            [['Remarks'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_id' => 'Trans ID',
            'trans_date' => 'Trans Date',
            'bill_number' => 'Bill Number',
            'control_number' => 'Control Number',
            'receipt_number' => 'Receipt Number',
            'paid_amount' => 'Paid Amount',
            'payment_channel' => 'Payment Channel',
            'account_number' => 'Account Number',
            'Remarks' => 'Remarks',
            'date_created' => 'Date Created',
			'receipt_number'=>'receipt_number',
			'amount_paid'=>'amount_paid',
        ];
    }
	
	  public function upload($date_time) {
        if ($this->validate()) {
            $this->controlNumberFile->saveAs('uploadscontrolnumber/' . $date_time . $this->controlNumberFile->baseName . '.' . $this->controlNumberFile->extension);
            return true;
        } else {
            $this->controlNumberFile->saveAs('uploadscontrolnumber/' . $date_time . $this->controlNumberFile->baseName . '.' . $this->controlNumberFile->extension);
            return false;
        }
    }
	public static function formatRowData($rowData) {
       $formattedRowData = str_replace(",", "", str_replace("  ", " ", str_replace("'", "", trim($rowData))));
       return $formattedRowData;
   }
}
