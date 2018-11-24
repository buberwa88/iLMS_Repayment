<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "gepg_bill".
 *
 * @property integer $id
 * @property string $bill_number
 * @property string $bill_request
 * @property integer $retry
 * @property integer $status
 * @property string $response_message
 * @property string $date_created
 * @property string $cancelled_reason
 * @property integer $cancelled_by
 * @property string $cancelled_date
 * @property integer $cancelled_response_status
 * @property string $cancelled_response_code
 */
class GepgBill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gepg_bill';
    }

    /**
     * @inheritdoc
     */
	 public $f4indexno;
	 public $bill_amount;
    public function rules()
    {
        return [
            [['bill_request'], 'string'],
            [['retry', 'status', 'cancelled_by', 'cancelled_response_status','application_id'], 'integer'],
            [['date_created', 'cancelled_date', 'application_id', 'f4indexno','bill_amount'], 'safe'],
            [['bill_number'], 'string', 'max' => 20],
            [['response_message', 'cancelled_reason'], 'string', 'max' => 500],
            [['cancelled_response_code'], 'string', 'max' => 50],
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
            'bill_request' => 'Bill Request',
            'retry' => 'Retry',
            'status' => 'Status',
            'response_message' => 'Response Message',
            'date_created' => 'Date Created',
            'cancelled_reason' => 'Cancelled Reason',
            'cancelled_by' => 'Cancelled By',
            'cancelled_date' => 'Cancelled Date',
            'cancelled_response_status' => 'Cancelled Response Status',
            'cancelled_response_code' => 'Cancelled Response Code',
			'application_id'=>'Application',
			'f4indexno'=>'Payer ID',
			'bill_amount'=>'Bill Amount',
        ];
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(\backend\modules\application\models\Application::className(), ['application_id' => 'application_id']);
    }
	
}
