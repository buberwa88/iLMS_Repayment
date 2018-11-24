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
    public function rules()
    {
        return [
            [['bill_request'], 'string'],
            [['retry', 'status', 'cancelled_by', 'cancelled_response_status'], 'integer'],
            [['date_created', 'cancelled_date'], 'safe'],
            [['bill_number'], 'string', 'max' => 20],
            [['response_message', 'cancelled_reason'], 'string', 'max' => 500],
            [['cancelled_response_code'], 'string', 'max' => 50],
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
        ];
    }
}
