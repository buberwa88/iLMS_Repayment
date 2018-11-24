<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "gepg_recon_master".
 *
 * @property integer $recon_master_id
 * @property string $recon_date
 * @property string $created_at
 * @property integer $status
 */
class GepgReconMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gepg_recon_master';
    }

    /**
     * @inheritdoc
     */
	 public $f4indexno;
	 public $bill_amount;
	 public $controlNumberFile;
	 public $file;
	 public $receipt_number;
	 public $amount_paid;
    public function rules()
    {
        return [
		    [['recon_date'], 'required'],
			[['recon_date','receipt_number','amount_paid'], 'required','on'=>'upload_payment_recon'],
            [['created_at','created_by','description'], 'safe'],
			[['controlNumberFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls', 'on' => 'upload_payment_recon2'],
			[['recon_date'], 'validateReconDate','skipOnEmpty' => false],
            [['status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recon_master_id' => 'Reconciliation ID',
            'recon_date' => 'Reconciliation Date',
            'created_at' => 'Created At',
            'status' => 'Status',
			'created_by' => 'Created By',
			'description' => 'Description',
			'receipt_number'=>'receipt_number',
			'amount_paid'=>'amount_paid',
        ];
    }
	public function validateReconDate($attribute, $params){
    // Maximum date today - 18 years
     $maxBirthday = new \DateTime();
     //$maxBirthday->sub(new \DateInterval('P18Y'));
    if($this->recon_date >= $maxBirthday->format('Y-m-d')){
        $this->addError($attribute,'Wrong Recon. Date');
    }
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
