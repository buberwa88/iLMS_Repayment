<?php

namespace frontend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "applicant".
 *
 * @property integer $applicant_id
 * @property integer $user_id
 * @property integer $identification_type_id
 * @property string $NID
 * @property string $sex
 * @property string $f4indexno
 * @property string $f6indexno
 * @property string $mailing_address
 * @property string $date_of_birth
 * @property integer $place_of_birth
 * @property string $disability_status
 * @property string $disability_document
 * @property string $birth_certificate_number
 * @property string $birth_certificate_document
 * @property string $identification_document
 * @property integer $	loan_summary_requested
 * @property string $loan_summary_requested_date
 * @property string $current_name
 * @property string $current_phone_number
 * @property string $tasaf_support
 * @property string $tasaf_support_document
 */
class Applicant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applicant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'f4indexno'], 'required'],
            [['user_id', 'identification_type_id', 'place_of_birth', '	loan_summary_requested'], 'integer'],
            [['date_of_birth', 'loan_summary_requested_date'], 'safe'],
            [['disability_status', 'tasaf_support'], 'string'],
            [['NID'], 'string', 'max' => 30],
            [['sex'], 'string', 'max' => 1],
            [['f4indexno', 'f6indexno'], 'string', 'max' => 45],
            [['mailing_address'], 'string', 'max' => 80],
            [['disability_document', 'current_name', 'tasaf_support_document'], 'string', 'max' => 200],
            [['birth_certificate_number'], 'string', 'max' => 100],
            [['birth_certificate_document', 'identification_document'], 'string', 'max' => 300],
            [['current_phone_number'], 'string', 'max' => 50],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_id' => 'Applicant ID',
            'user_id' => 'User ID',
            'identification_type_id' => 'Identification Type ID',
            'NID' => 'Nid',
            'sex' => 'Sex',
            'f4indexno' => 'F4indexno',
            'f6indexno' => 'F6indexno',
            'mailing_address' => 'Mailing Address',
            'date_of_birth' => 'Date Of Birth',
            'place_of_birth' => 'Place Of Birth',
            'disability_status' => 'Disability Status',
            'disability_document' => 'Disability Document',
            'birth_certificate_number' => 'Birth Certificate Number',
            'birth_certificate_document' => 'Birth Certificate Document',
            'identification_document' => 'Identification Document',
            'loan_summary_requested' => 'Loan Summary Requested',
            'loan_summary_requested_date' => 'Loan Summary Requested Date',
            'current_name' => 'Current Name',
            'current_phone_number' => 'Current Phone Number',
            'tasaf_support' => 'Tasaf Support',
            'tasaf_support_document' => 'Tasaf Support Document',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(\frontend\modules\appeal\models\Application::className(), ['applicant_id' => 'applicant_id']);
    }

}
