<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "gepg_cnumber".
 *
 * @property integer $id
 * @property string $bill_number
 * @property string $response_message
 * @property integer $retrieved
 * @property string $control_number
 * @property string $trsxsts
 * @property string $trans_code
 * @property string $date_received
 */
class GepgCnumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gepg_cnumber';
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
            [['retrieved'], 'integer'],
			[['bill_number','control_number','date_received'], 'required','on'=>'Control_number_upload'],
            [['date_received'], 'safe'],
            [['bill_number'], 'string', 'max' => 20],
            [['response_message'], 'string', 'max' => 1500],
            [['control_number', 'trans_code'], 'string', 'max' => 30],
			[['controlNumberFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls', 'on' => 'Control_number_upload2'],
            [['trsxsts'], 'string', 'max' => 10],
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
            'control_number' => 'Control Number',
            'trsxsts' => 'Trsxsts',
            'trans_code' => 'Trans Code',
            'date_received' => 'Date Received',
        ];
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
}

