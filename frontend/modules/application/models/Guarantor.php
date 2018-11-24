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
class Guarantor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applicant_associate';
    }

    /**
     * @inheritdoc
     */
      public $region_id;
      public $district_id;
     // public $organization_type;
    public function rules()
    {
        return [
             //[['guarantor_type','NID','identification_type_id'], 'required'],
               [['organization_type'], 'required', 'when' => function ($model) {
                    return $model->guarantor_type==1;
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#guarantor-guarantor_type').val() ==1; }"],
//           [['guarantor_position'], 'required', 'message' => 'Please Guarantor Position is requred.', 'when' => function($model) {
//                    if($model->guarantor_position ==1){
//                return  ($model->guarantor_position) ? 0:1;
//                    }
//                }, 'whenClient' => "function (attribute, value) {
//                    if ($('#guarantor-guarantor_position').val() == '') {
//                       return 1;
//                    } else {
//                       return 0;
//                    }
//                }"],
//            [['guaranteed_letter'], 'required', 'message' => 'Please Guarantee Letter is requred.', 'when' => function($model) {
//            if($model->guarantor_type ==1){
//            return  ($model->guaranteed_letter) ? 0:1;
//            }
//        }, 'whenClient' => "function (attribute, value) {
//            if ($('#guarantor-guarantor_type').val() == '') {
//               return 1;
//            } else {
//               return 0;
//            }
//        }"],
//             [['learning_institution_id'], 'required', 'when' => function ($model) {
//                    return $model->organization_type==1;
//                },
//                'whenClient' => "function (attribute, value) { "
//                . " return $('#guarantor-organization_type').val() ==1; }"],
//               [['region_id','organization_name','guarantor_type','district_id', 'firstname',  'surname', 'sex','phone_number', 'physical_address'], 'required', 'when' => function ($model) {
//                    return $model->organization_type>1;
//                },
//                'whenClient' => "function (attribute, value) { "
//                . " return $('#guarantor-organization_type').val()>1; }"],
              [['guarantor_type','identification_type_id','NID'], 'required', 'when' => function ($model) {
                    return $model->guarantor_type>1;
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#guarantor-guarantor_type').val()>1; }"],
              
          [['passport_photo'], 'required', 'message' => 'Please Attach Passport Photo', 'when' => function($model) {
           if($model->guarantor_type>1){
        return  ($model->passport_photo) ? 0:1;
            }
        }, 'whenClient' => "function (attribute, value) {
            if ($('#guarantor-guarantor_type').val()>1) {
               return 1;
            } else {
               return 0;
            }
            }"],
            [['application_id','region_id','guarantor_type','organization_type','district_id', 'firstname', 'middlename', 'surname', 'sex', 'phone_number', 'physical_address', 'NID','identification_document','identification_type_id', 'passport_photo','file_path','type','guarantor_position'], 'safe'],
            [['application_id', 'identification_type_id', 'occupation_id', '	passport_photo_verified', 'learning_institution_id', 'ward_id'], 'integer'],
            [['sex', 'disability_status', 'is_parent_alive', 'type'], 'string'],
            [['organization_name', 'physical_address', 'email_address', 'death_certificate_number'], 'string', 'max' => 100],
            [['firstname', 'middlename', 'surname'], 'string', 'max' => 45],
            [['postal_address', 'NID'], 'string', 'max' => 30],
            [['phone_number'], 'number'],
            [['phone_number'], 'match', 'pattern' =>'/^\d{10}$/'],
            ['passport_photo', 'image', 'minWidth' => 150, 'maxWidth' => 150,'minHeight' => 160, 'maxHeight' => 160, 'extensions' => 'jpg, png'],
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
            'application_id' => 'Application ',
            'organization_name' => 'Organization Name',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'sex' => 'Sex',
            'postal_address' => 'Postal Address',
            'phone_number' => 'Phone Number',
            'physical_address' => 'Physical Address',
            'email_address' => 'Email Address',
            'identification_type_id' => 'Identification Type ',
            'identification_document' => 'Identification Document',
            'NID' => 'Identification Number',
            'occupation_id' => 'Occupation ',
            'passport_photo' => 'Passport Photo',
            'passport_photo_verified' => 'Passport Photo Verified',
            'passport_photo_comment' => 'Passport Photo Comment',
            'disability_status' => 'Disability Status',
            'disability_document' => 'Disability Document',
            'is_parent_alive' => 'Is your Parent Alive',
            'death_certificate_document' => 'Death Certificate Document',
            'death_certificate_number' => 'Death Certificate Number',
            'type' => 'Type',
            'learning_institution_id' => 'Learning Institution ',
            'ward_id' => 'Ward Name',
            'district_id' => 'District Name',
            'region_id' => 'Region Name',
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
        return $this->hasOne(\backend\modules\application\models\Ward::className(), ['ward_id' => 'ward_id']);
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
  public static function checkguarantor($applicationId,$applicant_category_id){
            $status=1;
         $models=ApplicantAssociate::find()->where("application_id = {$applicationId} AND type = 'GA'")->all();
          if(count($models)>0){
          foreach($models as $model){  
            if(($applicant_category_id==2||$applicant_category_id=4||$applicant_category_id==5)&&$model->guaranteed_letter==""){
             $status=$status*0;  
            }
            ###################non-necta student
            if($model->is_necta==2&&$model->certificate_document==""){
               $status=$status*0;  
            }
            ########################end ################
            }
            }
            else{
              $status=$status*0;
            }
        return $status;
       }
}


?>