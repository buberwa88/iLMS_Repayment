<?php
namespace frontend\modules\application\models;
use Yii;
use backend\modules\application\models\Ward;

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
 * @property string $NID
 * @property integer $occupation_id
 * @property string $passport_photo
 * @property string $type
 * @property integer $learning_institution_id
 * @property integer $ward_id
 *
 * @property Application $application
 * @property LearningInstitution $learningInstitution
 * @property Occupation $occupation
 * @property Ward $ward
 */
class ApplicantAssociate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
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
            [['is_parent_alive'], 'required'],
            [['firstname','region_id','district_id','ward_id','occupation_id', 'surname', 'sex', 'phone_number', 'physical_address','postal_address','disability_status'], 'required', 'when' => function ($model) {
                    return $model->is_parent_alive =="YES";
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#applicantassociate-is_parent_alive').val() == 'YES'; }"],
            [['application_id','loan_repayed_by', 'firstname','region_id','death_certificate_number','death_certificate_document','is_parent_alive','disability_document','disability_status','identification_document','identification_type_id','district_id','ward_id','occupation_id','middlename', 'surname', 'sex', 'phone_number', 'physical_address','postal_address','type'], 'safe'],
            [['application_id', 'occupation_id', 'learning_institution_id', 'ward_id'], 'integer'],
            [['sex', 'type'], 'string'],
            [['email_address'],'email'],
            ['disability_document', 'required', 'when' => function ($model) {
                    return $model->disability_status =="YES";
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#applicantassociate-disability_status').val() == 'YES'; }"],
             [['death_certificate_document','death_certificate_number'], 'required', 'when' => function ($model) {
                    return $model->is_parent_alive =="NO";
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#applicantassociate-is_parent_alive').val() == 'NO'; }"],
            [['organization_name', 'physical_address', 'email_address'], 'string', 'max' => 100],
            [['firstname', 'middlename', 'surname'], 'string', 'max' => 45],
            [['postal_address', 'NID'], 'string', 'max' => 30],
            [['phone_number'], 'number'],
            [['phone_number'], 'match', 'pattern' =>'/^\d{10}$/'],
            [['phone_number'], 'validatePhone','skipOnEmpty' => false],
            [['passport_photo'], 'string', 'max' => 200],
             
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
            [['occupation_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Occupation::className(), 'targetAttribute' => ['occupation_id' => 'occupation_id']],
            [['ward_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Ward::className(), 'targetAttribute' => ['ward_id' => 'ward_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_associate_id' => 'Applicant Associate ID',
            'application_id' => 'Application ID',
            'organization_name' => 'Organization Name',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'sex' => 'Sex',
            'postal_address' => 'Postal Address',
            'phone_number' => 'Phone Number',
            'physical_address' => 'Physical Address',
            'district_id' => 'District Name',
            'region_id' => 'Region Name',
            'email_address' => 'Email Address',
            'NID' => 'Identification Number',
            'occupation_id' => 'Occupation',
            'passport_photo' => 'Passport Photo',
            'type' => 'Type',
            'learning_institution_id' => 'Learning Institution ',
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
        return $this->hasOne(\common\models\IdentificationType::className(), ['identification_type_id' => 'identification_type_id']);
    }
 public function validatePhone($attribute, $params){
           $test_start=$this->phone_number;
      if($test_start[0]!=0){
        $this->addError($attribute,'Phone number must start with Zero (0)');
    }
  }
}
