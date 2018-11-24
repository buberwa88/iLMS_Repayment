<?php

namespace frontend\modules\application\models;

use Yii;

/**
 * This is the model class for table "education".
 *
 * @property integer $education_id
 * @property integer $application_id
 * @property string $level
 * @property integer $learning_institution_id
 * @property string $registration_number
 * @property string $programme_name
 * @property string $programme_code
 * @property integer $entry_year
 * @property integer $completion_year
 * @property integer $division
 * @property double $points
 * @property integer $is_necta
 * @property string $class_or_grade
 * @property double $gpa_or_average
 * @property string $avn_number
 * @property integer $under_sponsorship
 * @property string $sponsor_proof_document
 * @property string $olevel_index
 * @property integer $alevel_index
 * @property string $institution_name
 *
 * @property Application $application
 * @property LearningInstitution $learningInstitution
 */
class Education extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $region_id;
    public $district_id;
    public $ward_id;
    public static function tableName()
    {
        return 'education';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['registration_number','institution_name','avn_number', 'programme_name', 'completion_year','under_sponsorship','region_id','district_id','ward_id'], 'required'],
               [['institution_name','entry_year','completion_year','under_sponsorship','region_id','district_id','ward_id'], 'required', 'when' => function ($model) {
                    return $model->level =="PRIMARY";
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#education-level').val() =='PRIMARY'; }"],
//            [['sponsor_proof_document'], 'required', 'when' => function ($model) {
//                    return $model->under_sponsorship ==1;
//                },
//                'whenClient' => "function (attribute, value) { "
//                . " return $('#education-under_sponsorship').val() == 1; }"],
            

[['sponsor_proof_document'], 'required', 'message' => 'Please Attach Sponsorship Document.', 'when' => function($model) {
            if($model->under_sponsorship ==1){
        return  ($model->sponsor_proof_document) ? 0:1;
            }
        }, 'whenClient' => "function (attribute, value) {
            if ($('#education-under_sponsorship').val() == '') {
               return 1;
            } else {
               return 0;
            }
        }"],
        [['institution_name','level','avn_number', 'programme_name', 'completion_year','under_sponsorship','admission_letter','employer_letter','region_id','country_id'], 'required', 'when' => function ($model) {
            if($model->level =="BACHELOR"||$model->level=="MASTERS"){
               return  1;
            }
            else{
             return 0;
            }
        }, 'whenClient' => "function (attribute, value) {
            if ($('#education-under_sponsorship').val() == '') {
               return 1;
            } else {
               return 0;
            }
        }"],

            [['registration_number','completion_year','under_sponsorship'], 'required', 'when' => function ($model) {
                    return $model->is_necta ==1;
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#switch_right').val() == 1; }"],
              [['registration_number','institution_name','completion_year','country_id','under_sponsorship'], 'required', 'when' => function ($model) {
                    return $model->is_necta ==2;
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#switch_right').val() == 2; }"],
              [['under_sponsorship','institution_name','avn_number', 'programme_name', 'completion_year'], 'required', 'when' => function ($model) {
                    return $model->is_necta ==3;
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#switch_right').val() == 3; }"],
            [['application_id', 'level','registration_number', 'entry_year', 'completion_year', 'avn_number','institution_name','division','points','country_id','registration_number_old','region_id'], 'safe'],
            [['application_id', 'learning_institution_id', 'entry_year', 'completion_year', 'division', 'is_necta', 'under_sponsorship','country_id'], 'integer'],
            ['completion_year', 'compare','compareAttribute'=>'entry_year','operator'=>'>', 'message'=>'Entry Year  should be less than Complete Year', 'type' => 'number'],
            //['entry_year', 'compare','compareAttribute'=>'completion_year','operator'=>'<', 'message'=>'Entry Year  should be less than Complete Year', 'type' => 'number'],
            [['entry_year','completion_year'], 'validateYear','skipOnEmpty' => false],
            [['level'], 'string'],
            [['points', 'gpa_or_average'], 'number'],
            [['registration_number', 'avn_number'], 'string', 'max' => 40],
            [['programme_name'], 'string', 'max' => 70],
            [['programme_code', 'class_or_grade'], 'string', 'max' => 20],
            [['sponsor_proof_document'], 'string', 'max' => 200],
            [['institution_name'], 'string', 'max' => 50],
            
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'education_id' => 'Education ID',
            'application_id' => 'Application ID',
            'level' => 'Level',
            'learning_institution_id' => 'Learning Institution ID',
            'registration_number' => 'Registration Number',
            'programme_name' => 'Programme Name',
            'programme_code' => 'Programme Code',
            'entry_year' => 'Entry Year',
            'completion_year' => 'Completion Year',
            'division' => 'Division',
             'ward_id' => 'Ward Name',
             'district_id' => 'District  Name',
             'region_id' => 'Region Name',
            'points' => 'Points',
            'is_necta' => 'Is Necta',
            'class_or_grade' => 'Class Or Grade',
            'gpa_or_average' => 'Gpa Or Average',
            'avn_number' => 'Avn Number',
            'under_sponsorship' => 'Were you sponsored ?',
            'sponsor_proof_document' => 'Sponsorship Proof Document',
            
            'institution_name' => 'Institution Name',
            'country_id'=>'Country Name'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['application_id' => 'application_id']);
    }
    
    
    
    public static function getOlevelDetails($index_and_year){
        
        $oindex_splitted = explode(".", $index_and_year);
        if(count($oindex_splitted) !== 3 ){
            return 'Wrong format. It must be Indexno concanated by completion year with a Dot Sign (".") Eg S1164.0035.2009';
        }
        
       $oyear = $oindex_splitted[2];
       //exit();
        $oindexall = trim(str_replace(".".$oyear,'',$index_and_year ));
        $oindex = trim(str_replace(".",'/',  $oindexall ));
        //$student_id = Yii::$app->user->identity->user_id;
               $student_id =1;
        //checking if table name exists
        $table = Yii::$app->db2->createCommand("SHOW TABLES LIKE 'tbl_{$oyear}_particulars' ")->queryOne();
        
        if($table === false){
            return "Completion year '{$oyear}' is Invalid. It must be a four digit year starting from 1988 to Current";
        }
        
        //checking results with NECTA
        $status = static::checkNectaResults($oindex, $oyear, 1, $student_id);
        if($status['status'] !== 1 ){
           return $status['message'];
        }
        $olevel_row = Yii::$app->db2->createCommand("select p.*, c.szExamCentreName AS szExamCentreName, c.szExamCentreNumber AS szExamCentreNumber from tbl_{$oyear}_particulars p left join tbl_{$oyear}_centres c ON c.Id = p.tbl_exam_centres_id where szCandidatesNumber = '{$oindex}' AND tbl_exam_types_Id = 1")->queryOne();
        if($olevel_row === false){
            
            return 'The Index number was not found. Please verify and try again';
        }
        $olevel_row['year'] = $oyear;
//        echo '<pre>';print_r($olevel_row);die('Hapaaaa');
        return $olevel_row;
     }
     
     public static function checkNectaResults($indexno, $year, $examtype, $student_id, $inst_code = 'UDSM'){
//         $logname = Yii::$app->params['sel_username'];
//        $pwd = Yii::$app->params['sel_password'];
        $url = Yii::$app->params['necta_url'];
        $data = array(
            'indexno'=>$indexno,
            'examyear'=>$year,
            'examtype'=>$examtype,
            'userid'=>$student_id,
            'inst_code'=>$inst_code,
        );
    

        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => json_encode($data),
                'header' => "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
            )
        );
       
        $context = stream_context_create($options);

        $result = file_get_contents($url, false, $context);
        return json_decode($result, true);
     }
   public static function getAlevelDetails($index_and_year){
        $aindex_splitted = explode(".", $index_and_year);
        if(count($aindex_splitted) !== 3 ){
            return 'Wrong format. It must be Indexno concanated by completion year with a "." Eg S1164.0035';
        }
        
        $ayear = $aindex_splitted[2];
        
        $aindexall = trim(str_replace(".".$ayear,'',$index_and_year ));
        $aindex = trim(str_replace(".",'/',  $aindexall ));
        $student_id = Yii::$app->user->identity->user_id;
         //checking results with NECTA
        $status = static::checkNectaResults($aindex, $ayear, 2, $student_id);
        if($status['status'] !== 1 ){
           return $status['message'];
        }
        $alevel_row = Yii::$app->db2->createCommand("select p.*, c.szExamCentreName AS szExamCentreName, c.szExamCentreNumber AS szExamCentreNumber from tbl_{$ayear}_particulars p left join tbl_{$ayear}_centres c ON c.Id = p.tbl_exam_centres_id where szCandidatesNumber = '{$aindex}' AND tbl_exam_types_Id = 2")->queryOne();
        if($alevel_row === false){
            
            return 'The Index number was not found. Please verify and try again';
        }
        $alevel_row['year'] = $ayear;
        return $alevel_row;
    }
    public static function getDivision($division){
        switch ($division) {
            case 'I':
                return 1;
                break;
            case 'II':
                return 2;
                break;
            case 'III':
                return 3;
                break;
            case 'IV':
                return 4;
                break;
            
            
           case 'DISTINCTION':
                return 1;
                break;
            case 'MERIT':
                return 2;
                break;
            case 'CREDIT':
                return 3;
                break;
            case 'PASS':
                return 4;
                break;
            
            
            

            default:
                return 5;
                break;
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution()
    {
        return $this->hasOne(\backend\modules\application\models\LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }
   public function validateDateOfBirth($attribute, $params){
    // Maximum date today - 18 years
     $maxBirthday = new \DateTime();
     $maxBirthday->sub(new \DateInterval('P15Y'));
    if($this->date_of_birth > $maxBirthday->format('Y-m-d')){
        $this->addError($attribute,'Please give correct Date of Birth');
    }
  }
   public function validateYear($attribute, $params){
    // Maximum date today - 18 years
        $year=$this->completion_year-$this->entry_year;    
    if($year>7&&$this->level=="PRIMARY"){
        $this->addError($attribute,'Please give correct Entry and Complete Year');
    }
//  else if($year>4&&$this->level=="OLEVEL"){
//        $this->addError($attribute,'Please give correct Entry and Complete Year');
//    }
//  else if($year>2&&$this->level=="ALEVEL"){
//        $this->addError($attribute,'Please give correct Entry and Complete Year');
//    }
//   else if($year>0&&$this->level=="COLLEGE"||$this->level=="BACHELOR"||$this->level=="MASTERS"){
//        $this->addError($attribute,'Please give correct Entry and Complete Year');
//    }
    //'PRIMARY','OLEVEL','ALEVEL','COLLEGE','BACHELOR','MASTERS'
  }
 public static function getEducationDetails($application_id,$education_level){
      $education_details = Education::find()->where(['application_id' => $application_id,'level' => $education_level])->with('learningInstitution')->one();
      return $education_details;
    }
  public static function getcheckeducation($level,$applicationId){
            $model=\frontend\modules\application\models\Education::find()->where("level='{$level}' AND application_id='{$applicationId}' AND under_sponsorship<>0")->count();  
            return $model;
                 }
}
