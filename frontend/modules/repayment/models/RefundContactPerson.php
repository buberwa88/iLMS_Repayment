<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_contact_person".
 *
 * @property integer $refund_contact_person_id
 * @property integer $refund_application_id
 * @property string $firstname
 * @property string $middlename
 * @property string $surname
 * @property string $created_at
 * @property string $updated_at
 * @property string $phone_number
 * @property string $email_address
 */
class RefundContactPerson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_contact_person';
    }

    /**
     * @inheritdoc
     */
    public $claimant_letter_document;
    public function rules()
    {
        return [
            [['refund_application_id'], 'integer'],
            [['firstname','surname','phone_number'], 'required','on'=>'refundClaimantContactUpdate'],
            [['claimant_letter_document'], 'file', 'extensions'=>['pdf']],
            [['created_at', 'updated_at'], 'safe'],
            [['firstname', 'middlename', 'surname'], 'string', 'max' => 45],
            [['phone_number', 'email_address'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_contact_person_id' => 'Refund Contact Person ID',
            'refund_application_id' => 'Refund Application ID',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'phone_number' => 'Phone Number',
            'email_address' => 'Email Address',
            'claimant_letter_document'=>'Claimant letter document',
        ];
    }
	public function getRefundApplication()
    {
        return $this->hasOne(RefundApplication::className(), ['refund_application_id' => 'refund_application_id']);
    }
	public static function getStageChecked($refund_application_id ){
        $details_ = self::find()
            ->select('phone_number')
            ->where(['refund_application_id'=>$refund_application_id])
            ->one();
        $results=count($details_->phone_number);
        return $results;
    }
}
