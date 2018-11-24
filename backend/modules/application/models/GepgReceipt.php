<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "gepg_receipt".
 *
 * @property integer $id
 * @property string $bill_number
 * @property string $response_message
 * @property integer $retrieved
 * @property string $trans_id
 * @property string $payer_ref_id
 * @property string $control_number
 * @property double $bill_amount
 * @property double $paid_amount
 * @property string $currency
 * @property string $trans_date
 * @property string $payer_phone
 * @property string $payer_name
 * @property string $receipt_number
 * @property string $account_number
 * @property integer $reconciliation_status
 * @property string $amount_diff
 * @property integer $recon_master_id
 */
class GepgReceipt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gepg_receipt';
    }

    /**
     * @inheritdoc
     */
	 //public $f4indexno;
         
         public $f4indexno;
	 //public $bill_amount;
	 public $controlNumberFile;
	 public $file;
         public $trans_dateF;

    public function rules()
    {
        return [
            [['response_message'], 'string'],
            [['retrieved', 'reconciliation_status', 'recon_master_id'], 'integer'],
            [['control_number','paid_amount','receipt_number','trans_date'], 'required','on'=>'payments_upload'],
            [['control_number', 'bill_amount', 'paid_amount', 'amount_diff','recon_amount'], 'number'],
            [['trans_date','f4indexno','trans_dateF','transact_date_gepg'], 'safe'],
            [['bill_number'], 'string', 'max' => 20],
            [['trans_id', 'payer_ref_id'], 'string', 'max' => 50],
            [['currency'], 'string', 'max' => 3],
            [['payer_phone'], 'string', 'max' => 13],
            [['payer_name'], 'string', 'max' => 40],
            [['receipt_number', 'account_number'], 'string', 'max' => 30],
            [['controlNumberFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls', 'on' => 'payments_upload2'],
			[['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bill_number' => 'Bill Number',
            'response_message' => 'Response Message',
            'retrieved' => 'Retrieved',
            'trans_id' => 'Trans ID',
            'payer_ref_id' => 'Payer Ref ID',
            'control_number' => 'Control Number',
            'bill_amount' => 'Bill Amount',
            'paid_amount' => 'Paid Amount',
            'currency' => 'Currency',
            'trans_date' => 'Trans Date',
            'payer_phone' => 'Payer Phone',
            'payer_name' => 'Payer Name',
            'receipt_number' => 'Receipt Number',
            'account_number' => 'Account Number',
            'reconciliation_status' => 'Reconciliation Status',
            'amount_diff' => 'Amount Diff',
            'recon_master_id' => 'Recon Master ID',
			'recon_amount'=>'Reconciliation Amount',
			'application_id'=>'Application',
			'f4indexno'=>'Payer ID',
                        'trans_dateF'=>'Date',
                        'transact_date_gepg'=>'Date',
        ];
    }
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(\backend\modules\application\models\Application::className(), ['application_id' => 'application_id']);
    }

   public function upload($date_time) {
        if ($this->validate()) {
            $this->controlNumberFile->saveAs('/var/www/html/olams/backend/web/uploadscontrolnumber/' . $date_time . $this->controlNumberFile->baseName . '.' . $this->controlNumberFile->extension);
            return true;
        } else {
            $this->controlNumberFile->saveAs('/var/www/html/olams/backend/web/uploadscontrolnumber/' . $date_time . $this->controlNumberFile->baseName . '.' . $this->controlNumberFile->extension);
            return false;
        }
    }
	public static function formatRowData($rowData) {
       $formattedRowData = str_replace(",", "", str_replace("  ", " ", str_replace("'", "", trim($rowData))));
       return $formattedRowData;
   }

public static function getTransDate($receipt_number){
        $date_receipt = GepgReceipt::find()
		->select('transact_date_gepg')
		->where(['receipt_number'=>$receipt_number])
		->orderBy('id DESC')
		->one();
        $date_=date("Y-m-d H:i:s",strtotime($date_receipt->transact_date_gepg));
        return $date_;
        }

}

