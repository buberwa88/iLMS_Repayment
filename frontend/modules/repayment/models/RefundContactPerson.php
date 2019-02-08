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
    public function rules()
    {
        return [
            [['refund_application_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['firstname', 'middlename', 'surname'], 'string', 'max' => 45],
            [['phone_number', 'email_address'], 'string', 'max' => 20],
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
        ];
    }
	public function getRefundApplication()
    {
        return $this->hasOne(RefundApplication::className(), ['refund_application_id' => 'refund_application_id']);
    }
}
