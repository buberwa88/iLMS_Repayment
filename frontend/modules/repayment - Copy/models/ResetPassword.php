<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ResetPassword extends Model
{
	public $f4indexno;
	public $beneficiaryCurrentEmail;
	public $region;
	public $district;
	public $ward;
	public $learningInstitution;
	public $dateOfBirth;
	public $employerCode;
	public $employerOfficeEmail;
	public $contactPersonEmail;
	public $firstname;
	public $middlename;
	public $surname;
	public $programme_name;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['f4indexno', 'beneficiaryCurrentEmail', 'region', 'district', 'ward', 'learningInstitution','dateOfBirth'], 'required', 'on'=>'beneficiary_reset_password'],
            // email has to be a valid email address
            ['beneficiaryCurrentEmail', 'email'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'verifyCode' => 'Verification Code',
			'f4indexno' => 'Form IV Index Number:',
			'beneficiaryCurrentEmail'=>'Current Email Address:',
			'region'=>'Region:',
			'district'=>'District:',
			'ward'=>'Ward:',
			'learningInstitution'=>'Learning Institution:',
			'dateOfBirth'=>'Date of Birth:',
			'firstname'=>'First Name',
			'middlename'=>'Middle Name',
			'surname'=>'Last Name',
			'programme_name'=>'Programme',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
