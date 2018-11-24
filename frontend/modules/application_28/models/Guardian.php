<?php

namespace frontend\modules\application\models;

use Yii;

/**
 * This is the model class for table "applicant_associate".
 *
 * @property integer $applicant_associate_id
 * @property integer $application_id
 * @property string $organization_name
 * @property string $firstname
 * @property string $middlename
 * @property string $surname
 * @property string $sex
 * @property string $postal_address
 * @property string $phone_number
 * @property string $physical_address
 * @property string $email_address
 * @property integer $identification_type_id
 * @property string $identification_document
 * @property string $NID
 * @property integer $occupation_id
 * @property string $passport_photo
 * @property integer $	passport_photo_verified
 * @property string $passport_photo_comment
 * @property string $disability_status
 * @property string $disability_document
 * @property string $is_parent_alive
 * @property string $death_certificate_document
 * @property string $death_certificate_number
 * @property string $type
 * @property integer $learning_institution_id
 * @property integer $ward_id
 *
 * @property Application $application
 * @property LearningInstitution $learningInstitution
 * @property Occupation $occupation
 * @property Ward $ward
 * @property IdentificationType $identificationType
 */
class Guardian extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc do you have guardian ?
     */
     
    public $region_id;
    public $district_id;
    public static function tableName()
    {
        return 'applicant_associate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             [['having_guardian'], 'required'],
             [['firstname','region_id','district_id','ward_id','occupation_id', 'surname', 'sex', 'phone_number', 'physical_address','postal_address','type'], 'required', 'when' => function ($model) {
                    return $model->having_guardian =="NO";
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#guardian-having_guardian').val() == 'NO'; }"],
           // [['application_id', 'firstname', 'middlename', 'surname', 'sex', 'phone_number', 'physical_address', 'NID', 'passport_photo', 'type'], 'required'],
            [['application_id', 'identification_type_id', 'occupation_id', '	passport_photo_verified', 'learning_institution_id', 'ward_id'], 'integer'],
            [['sex', 'disability_status', 'is_parent_alive', 'type'], 'string'],
            [['organization_name', 'physical_address', 'email_address', 'death_certificate_number'], 'string', 'max' => 100],
            [['firstname', 'middlename', 'surname'], 'string', 'max' => 45],
            [['postal_address', 'NID'], 'string', 'max' => 30],
            [['phone_number'], 'number'],
            [['phone_number'], 'match', 'pattern' =>'/^\d{10}$/'],
            [['phone_number'], 'validatePhone','skipOnEmpty' => false],
            [['identification_document', 'passport_photo_comment', 'disability_document', 'death_certificate_document'], 'string', 'max' => 300],
            [['passport_photo'], 'string', 'max' => 200],
            [['email_address'],'email'],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
            [['occupation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Occupation::className(), 'targetAttribute' => ['occupation_id' => 'occupation_id']],
            [['ward_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Ward::className(), 'targetAttribute' => ['ward_id' => 'ward_id']],
            [['identification_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\IdentificationType::className(), 'targetAttribute' => ['identification_type_id' => 'identification_type_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_associate_id' => 'Applicant Associate ID',
            'guardian_status'=>"Do you have guardian ( Unamleze ) ?",
            'application_id' => 'Application ID',
            'organization_name' => 'Organization Name',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'sex' => 'Sex',
            'postal_address' => 'Postal Address',
            'phone_number' => 'Phone Number',
            'physical_address' => 'Physical Address',
            'email_address' => 'Email Address',
            'identification_type_id' => 'Identification Type ID',
            'identification_document' => 'Identification Document',
            'NID' => 'Nid',
            'occupation_id' => 'Occupation ID',
            'passport_photo' => 'Passport Photo',
            '	passport_photo_verified' => 'Passport Photo Verified',
            'passport_photo_comment' => 'Passport Photo Comment',
            'disability_status' => 'Disability Status',
            'disability_document' => 'Disability Document',
            'is_parent_alive' => 'Is Parent Alive',
            'death_certificate_document' => 'Death Certificate Document',
            'death_certificate_number' => 'Death Certificate Number',
            'type' => 'Type',
            'learning_institution_id' => 'Learning Institution',
            'ward_id' => 'Ward Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution()
    {
        return $this->hasOne(LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccupation()
    {
        return $this->hasOne(Occupation::className(), ['occupation_id' => 'occupation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWard()
    {
        return $this->hasOne(Ward::className(), ['ward_id' => 'ward_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdentificationType()
    {
        return $this->hasOne(IdentificationType::className(), ['identification_type_id' => 'identification_type_id']);
    }
    public function validatePhone($attribute, $params){
           $test_start=$this->phone_number;
      if($test_start[0]!=0){
        $this->addError($attribute,'Phone number must start with Zero (0)');
    }
   
  }
}
