<?php

namespace frontend\modules\application\controllers;

use Yii;
use frontend\modules\application\models\Education;
use frontend\modules\application\models\EducationSearch;
use backend\modules\allocation\models\base\LearningInstitution;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\Applicant;
use yii\web\UploadedFile;

/**
 * EducationController implements the CRUD actions for Education model.
 */
class EducationController extends Controller {

    public $layout = "main_public_beneficiary";

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                //'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Education models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new EducationSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionPrimaryView() {
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();

        $modelNew = new Education();

        if ($modelNew->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;
            $modelUser = \common\models\User::findOne($user_id);
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $modelNew->application_id = $modelApplication->application_id;
            $modelNew->registration_number = NULL;
            $modelNew->level = 'PRIMARY';
                        $toValidate = [
                            'institution_name',
                            'entry_year',
                            'district_id',
                            'region_id',
                            'under_sponsorship',
                            'sponsor_proof_document',
                            'completion_year',
                        ];
     /* Get Institution Information
             */
//            $institutioncode = explode(".", $modelNew->registration_number)[0];
//            $institution_id = $this->getInstitutionId($institutioncode, $model["szExamCentreName"]);

            /*
             * end search institution information
             */
              $toValidate_app = [
                'institution_name',
               // 'institution_code',
            ];
            $model_app = new LearningInstitution();
           // $model_app->institution_code =NULL;
            $model_app->entered_by_applicant = 1;
            $model_app->ward_id=$modelNew->ward_id;
            $model_app->institution_name = $modelNew->institution_name;
            if ($model_app->validate($toValidate_app, false)) {
                if ($model_app->save(false)) {
                   // $model_app->learning_institution_id;
                }
            }
            $modelNew->learning_institution_id =$model_app->learning_institution_id;
            $modelNew->sponsor_proof_document = UploadedFile::getInstance($modelNew, 'sponsor_proof_document');


            if ($modelNew->sponsor_proof_document != "") {
                $modelNew->sponsor_proof_document->saveAs('applicant_attachment/' . $modelNew->sponsor_proof_document->name);
                $modelNew->sponsor_proof_document = 'applicant_attachment/' . $modelNew->sponsor_proof_document->name;
            } else {
                $modelNew->sponsor_proof_document = $modelNew->OldAttributes['sponsor_proof_document'];
            }
            if ($modelNew->validate($toValidate, TRUE)) {
                if ($modelNew->save()) {
                    return $this->redirect(['primary-view']);
                }
            }
        }
        return $this->render('primary_view', [
                    'modelApplication' => $modelApplication,
                    'modelNew' => $modelNew
        ]);
    }

    public function actionPrimaryCreate() {
        $model = new Education;

        if ($model->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;

            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $model->application_id = $modelApplication->application_id;
            $model->registration_number = NULL;
            $model->level = 'PRIMARY';
            $toValidate = [
                'institution_name',
                'entry_year',
                // 'registration_number',
                'under_sponsorship',
                'sponsor_proof_document',
                'completion_year',
            ];

            if ($model->validate($toValidate, false)) {
                if ($model->save(false)) {
                    return $this->redirect(['primary-view']);
                }
            }
        }
        return $this->render('primary_create', [
                    'model' => $model,
        ]);
    }

    public function actionPrimaryUpdate($id) {
        $model = Education::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;

            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $model->application_id = $modelApplication->application_id;
            $model->registration_number = NULL;
            $model->level = 'PRIMARY';

            $toValidate = [
                'institution_name',
                'entry_year',
                // 'registration_number',
                'under_sponsorship',
                'sponsor_proof_document',
                'completion_year',
            ];
            // $model->validate();
            //print_r($model->errors);die();
               if($model->under_sponsorship==1){
                $model->sponsor_proof_document = UploadedFile::getInstance($model, 'sponsor_proof_document');
                if ($model->sponsor_proof_document != "") {
                    $model->sponsor_proof_document->saveAs('applicant_attachment/' . $model->sponsor_proof_document->name);
                    $model->sponsor_proof_document = 'applicant_attachment/' . $model->sponsor_proof_document->name;
                } else {
                    $model->sponsor_proof_document = $model->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $model->sponsor_proof_document=Null;     
                  }
            if ($model->validate($toValidate, false)) {
                if ($model->save(false)) {

                    return $this->redirect(['primary-view']);
                }
            }
        }
        return $this->render('primary_update', [
                    'model' => $model,
        ]);
    }

    public function actionOlevelView() {
        $user_id = Yii::$app->user->identity->user_id;
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
        $modelNew = new Education();

        if ($modelNew->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;
            $index = Yii::$app->request->post("registrationId") . "/" . Yii::$app->request->post("year");
            $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
            $sqlitem = Yii::$app->db->createCommand("SELECT count(*) FROM `applicant` a join application app on a.`applicant_id`=app.`applicant_id` WHERE a.`f4indexno`='{$index}' AND `academic_year_id`='{$model_year->academic_year_id}'")->queryScalar();

            #####################end check###################
            if ($sqlitem == 0) {
                $model = Education::getOlevelDetails($index);
                // print_r($model);
                if (!is_array($model)) {
                    return "<h4><font color='red'>" . $model . "</font></h4>";
                }
                $modelNew->application_id = $modelApplication->application_id;
                $modelNew->level = 'OLEVEL';
                $modelNew->institution_name = $model["szExamCentreName"];
                $toValidate = [
                    'institution_name',
                    'registration_number',
                    'under_sponsorship',
                    'sponsor_proof_document',
                    'completion_year',
                ];
                 /* Get Institution Information
             */
            $institutioncode = explode(".", $modelNew->registration_number)[0];
            $institution_id = $this->getInstitutionId($institutioncode, $model["szExamCentreName"]);

            /*
             * end search institution information
             */
            $modelNew->learning_institution_id = $institution_id;
                $modelNew->sponsor_proof_document = UploadedFile::getInstance($modelNew, 'sponsor_proof_document');
                   if($modelNew->under_sponsorship==1){
                $modelNew->sponsor_proof_document = UploadedFile::getInstance($modelNew, 'sponsor_proof_document');
                if ($modelNew->sponsor_proof_document != "") {
                    $modelNew->sponsor_proof_document->saveAs('applicant_attachment/' . $modelNew->sponsor_proof_document->name);
                    $modelNew->sponsor_proof_document = 'applicant_attachment/' . $modelNew->sponsor_proof_document->name;
                } else {
                    $modelNew->sponsor_proof_document = $modelNew->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $modelNew->sponsor_proof_document=Null;     
                  }
                if ($modelNew->validate($toValidate, false)) {
                    if ($modelNew->save(false)) {
                        return $this->redirect(['olevel-view']);
                    }
                }
            } else {
                // $index_exist="halaa";
            }
        }
        return $this->render('olevel_view', [
                    'modelApplication' => $modelApplication,
                    'modelNew' => $modelNew
        ]);
    }

    public function actionOlevelCreate() {

        $modelNew = new Education();

        if ($modelNew->load(Yii::$app->request->post())) {

            $user_id = Yii::$app->user->identity->id;
            $index = $modelNew->registration_number . "." . $modelNew->completion_year;
            // $modelUser = \common\models\User::findOne($user_id);
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $modelNew->application_id = $modelApplication->application_id;
            $model_year = \common\models\AcademicYear::findOne(["is_current" => 1]);
            $sqlitem = Yii::$app->db->createCommand("SELECT count(*) FROM `applicant` a join application app on a.`applicant_id`=app.`applicant_id` WHERE a.`f4indexno`='{$index}' AND `academic_year_id`='{$model_year->academic_year_id}'")->queryScalar();

            #####################end check###################

            if ($sqlitem == 0) {
                if ($modelNew->is_necta == 1) {
                    // print_r($modelNew);
                    // $modelNew->geterrors();
                    //exit();   
                    $model = Education::getOlevelDetails($index);
                    // print_r($model);
                    if (!is_array($model)) {
                    \Yii::$app->session->setFlash('errorMessage',$model);
                   $modelNew->addError('registration_number', $model);
                   return $this->render('olevel_create', [
                    'model' => $modelNew,
                              ]);
                    }
                    $modelNew->application_id = $modelApplication->application_id;
                    $modelNew->level = 'OLEVEL';
                    $modelNew->institution_name = $model["szExamCentreName"];
                    $toValidate = [
                        'institution_name',
                        'registration_number',
                        'learning_institution_id',
                        'under_sponsorship',
                        'sponsor_proof_document',
                        'completion_year',
                    ];
                               /*
             * Get Institution Information
             */
            $institutioncode = explode(".", $modelNew->registration_number)[0];
            $institution_id = $this->getInstitutionId($institutioncode, $model["szExamCentreName"]);

            /*
             * end search institution information
             */
            $modelNew->learning_institution_id = $institution_id;
                      if($modelNew->under_sponsorship==1){
                $modelNew->sponsor_proof_document = UploadedFile::getInstance($modelNew, 'sponsor_proof_document');
                if ($modelNew->sponsor_proof_document != "") {
                    $modelNew->sponsor_proof_document->saveAs('applicant_attachment/' . $modelNew->sponsor_proof_document->name);
                    $modelNew->sponsor_proof_document = 'applicant_attachment/' . $modelNew->sponsor_proof_document->name;
                } else {
                    $modelNew->sponsor_proof_document = $modelNew->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $modelNew->sponsor_proof_document=Null;     
                  }
                    if ($modelNew->validate($toValidate, false)) {
                        if ($modelNew->save(false)) {
                           
                        }
                    }
                 
                return $this->redirect(['olevel-view']);     
                } else {
                    $modelNew->level = 'OLEVEL';
                    $toValidate = [
                        'institution_name',
                        'registration_number',
                        'under_sponsorship',
                        'sponsor_proof_document',
                        'completion_year',
                        'country_id'
                    ];
                                           /*
             * Get Institution Information
             */
            $institutioncode =NULL;
            $institution_id = $this->getInstitutionId($institutioncode, $modelNew->institution_name);

            /*
             * end search institution information
             */
                    $modelNew->learning_institution_id = $institution_id;
                    $modelNew->application_id = $modelApplication->application_id;
                     if($modelNew->under_sponsorship==1){
                $modelNew->sponsor_proof_document = UploadedFile::getInstance($modelNew, 'sponsor_proof_document');
                if ($modelNew->sponsor_proof_document != "") {
                    $modelNew->sponsor_proof_document->saveAs('applicant_attachment/' . $modelNew->sponsor_proof_document->name);
                    $modelNew->sponsor_proof_document = 'applicant_attachment/' . $modelNew->sponsor_proof_document->name;
                } else {
                    $modelNew->sponsor_proof_document = $modelNew->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $modelNew->sponsor_proof_document=Null;     
                  }
                    if ($modelNew->validate($toValidate, false)) {
                        if ($modelNew->save(false)) {
                            return $this->redirect(['olevel-view']);
                        }
                    }
                }
            } else {
                //  $index_exist="halaa";
                Yii::$app->getSession()->setFlash('warning', "Sorry this form Four Index Number  $index already exit ");
            }
        }
//         
        return $this->render('olevel_create', [
                    'model' => $modelNew,
        ]);
    }

    public function actionOlevelUpdate($id) {
        $modelNew = Education::findOne($id);

        if ($modelNew->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;
            $index = $modelNew->registration_number . "." . $modelNew->completion_year;
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $modelNew->application_id = $modelApplication->application_id;

            if ($modelNew->is_necta == 1) {
                $model = Education::getOlevelDetails($index);
                  // print_r($model);
                    if (!is_array($model)) {
                    \Yii::$app->session->setFlash('errorMessage',$model);
                   $modelNew->addError('registration_number', $model);
                    return $this->render('olevel_update', [
                     'model' => $modelNew,
                              ]);
                    }
                $modelNew->application_id = $modelApplication->application_id;
                $modelNew->level = 'OLEVEL';
                $modelNew->institution_name = $model["szExamCentreName"];
                $toValidate = [
                    'institution_name',
                    'registration_number',
                    'under_sponsorship',
                    'sponsor_proof_document',
                    'completion_year',
                ];
                   /*
             * Get Institution Information
             */
            $institutioncode = explode(".", $modelNew->registration_number)[0];
           $institution_id = $this->getInstitutionId($institutioncode, Yii::$app->request->post("institution"));

            /*
             * end search institution information
             */
            $modelNew->learning_institution_id = $institution_id;
                   if($modelNew->under_sponsorship==1){
                $modelNew->sponsor_proof_document = UploadedFile::getInstance($modelNew, 'sponsor_proof_document');
                if ($modelNew->sponsor_proof_document != "") {
                    $modelNew->sponsor_proof_document->saveAs('applicant_attachment/' . $modelNew->sponsor_proof_document->name);
                    $modelNew->sponsor_proof_document = 'applicant_attachment/' . $modelNew->sponsor_proof_document->name;
                } else {
                    $modelNew->sponsor_proof_document = $modelNew->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $modelNew->sponsor_proof_document=Null;     
                  }
                if ($modelNew->validate($toValidate, false)) {
                    if ($modelNew->save(false)) {
                        return $this->redirect(['olevel-view']);
                    }
                }
            } else {
                $modelNew->level = 'OLEVEL';
                $toValidate = [
                    'institution_name',
                    'registration_number',
                    'under_sponsorship',
                    'sponsor_proof_document',
                    'completion_year',
                    'country_id'
                ];
                ################kimeo################
             /* Get Institution Information
             */
           $institutioncode =NUll;
          $modelNew->institution_name;
          $institution_id = $this->getInstitutionId($institutioncode, $modelNew->institution_name);
         
            /*
             * end search institution information
             */
        
                    $modelNew->learning_institution_id = $institution_id;
                ###############end kimeo##############
                $modelNew->application_id = $modelApplication->application_id;
              // $modelNew->sponsor_proof_document = UploadedFile::getInstance($modelNew, 'sponsor_proof_document');
                       if($modelNew->under_sponsorship==1){
                $modelNew->sponsor_proof_document = UploadedFile::getInstance($modelNew, 'sponsor_proof_document');
                if ($modelNew->sponsor_proof_document != "") {
                    $modelNew->sponsor_proof_document->saveAs('applicant_attachment/' . $modelNew->sponsor_proof_document->name);
                    $modelNew->sponsor_proof_document = 'applicant_attachment/' . $modelNew->sponsor_proof_document->name;
                } else {
                    $modelNew->sponsor_proof_document = $modelNew->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $modelNew->sponsor_proof_document=Null;     
                  }
                if ($modelNew->validate($toValidate, false)) {
                    if ($modelNew->save(false)) {
                        return $this->redirect(['olevel-view']);
                    }
                }
            }
 
        }
        return $this->render('olevel_update', [
                    'model' => $modelNew,
        ]);
    }
   public function actionOlevelUpdates($id) {
        $modelNew = Education::findOne($id);

        if ($modelNew->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;
            $index = $modelNew->registration_number . "." . $modelNew->completion_year;
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $modelNew->application_id = $modelApplication->application_id;

            if ($modelNew->is_necta == 1) {
                
//                echo "mickidadi";
//                  exit();
                //$model = Education::getOlevelDetails($index);
                  // print_r($model);
//                    if (!is_array($model)) {
//                    \Yii::$app->session->setFlash('errorMessage',$model);
//                   $modelNew->addError('registration_number', $model);
//                    return $this->render('olevel_updates', [
//                     'model' => $modelNew,
//                              ]);
//                    }
              //  $modelNew->application_id = $modelApplication->application_id;
                //$modelNew->level = 'OLEVEL';
               // $modelNew->institution_name = $model["szExamCentreName"];
                $toValidate = [
                    //'institution_name',
                    //'registration_number',
                    'under_sponsorship',
                    'sponsor_proof_document',
                    //'completion_year',
                ];
                   /*
             * Get Institution Information
             */
//            $institutioncode = explode(".", $modelNew->registration_number)[0];
//            $institution_id = $this->getInstitutionId($institutioncode, Yii::$app->request->post("institution"));

            /*
             * end search institution information
             */
           // $modelNew->learning_institution_id = $institution_id;
                  if($modelNew->under_sponsorship==1){
                $modelNew->sponsor_proof_document = UploadedFile::getInstance($modelNew, 'sponsor_proof_document');
                if ($modelNew->sponsor_proof_document != "") {
                    $modelNew->sponsor_proof_document->saveAs('applicant_attachment/' . $modelNew->sponsor_proof_document->name);
                    $modelNew->sponsor_proof_document = 'applicant_attachment/' . $modelNew->sponsor_proof_document->name;
                } else {
                    $modelNew->sponsor_proof_document = $modelNew->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $modelNew->sponsor_proof_document=Null;     
                  }
                if ($modelNew->validate($toValidate, false)) {
                    if ($modelNew->save(false)) {
                        return $this->redirect(['olevel-view']);
                    }
                }
            } else {
                $modelNew->level = 'OLEVEL';
                $toValidate = [
                    //'institution_name',
                   // 'registration_number',
                    'under_sponsorship',
                    'sponsor_proof_document',
                    //'completion_year',
                    //'country_id'
                ];
                $modelNew->application_id = $modelApplication->application_id;
                  if($modelNew->under_sponsorship==1){
                $modelNew->sponsor_proof_document = UploadedFile::getInstance($modelNew, 'sponsor_proof_document');
                if ($modelNew->sponsor_proof_document != "") {
                    $modelNew->sponsor_proof_document->saveAs('applicant_attachment/' . $modelNew->sponsor_proof_document->name);
                    $modelNew->sponsor_proof_document = 'applicant_attachment/' . $modelNew->sponsor_proof_document->name;
                } else {
                    $modelNew->sponsor_proof_document = $modelNew->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $modelNew->sponsor_proof_document=Null;     
                  }
                if ($modelNew->validate($toValidate, false)) {
                    if ($modelNew->save(false)) {
                        return $this->redirect(['olevel-view']);
                    }
                }
            }
 
        }
        return $this->render('olevel_updates', [
                    'model' => $modelNew,
        ]);
    }
    public function actionAlevelView() {
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();

        $model = new Education;
        if ($model->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;
            $modelUser = \common\models\User::findOne($user_id);
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $model->application_id = $modelApplication->application_id;
            $model->level = 'ALEVEL';

            $toValidate = [
                'registration_number',
                'under_sponsorship',
                'sponsor_proof_document',
                'completion_year',
                'learning_institution_id',
                'is_necta'
            ];
            /*
             * Get Institution Information
             */
            $institutioncode = explode(".", $model->registration_number)[0];
            $institution_id = $this->getInstitutionId($institutioncode, Yii::$app->request->post("institution"));

            /*
             * end search institution information
             */
            $model->learning_institution_id = $institution_id;
              if($model->under_sponsorship==1){
                $model->sponsor_proof_document = UploadedFile::getInstance($model, 'sponsor_proof_document');
                if ($model->sponsor_proof_document != "") {
                    $model->sponsor_proof_document->saveAs('applicant_attachment/' . $model->sponsor_proof_document->name);
                    $model->sponsor_proof_document = 'applicant_attachment/' . $model->sponsor_proof_document->name;
                } else {
                    $model->sponsor_proof_document = $model->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $model->sponsor_proof_document=Null;     
                  }

            if ($model->validate($toValidate, false)) {
                if ($model->save(false)) {
                    return $this->redirect(['alevel-view']);
                }
            }
        }
        return $this->render('alevel_view', [
                    'modelApplication' => $modelApplication,
                    'modelNew' => $model
        ]);
    }

    public function actionAlevelCreate() {
        $model = new Education;
        if ($model->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->user_id;
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $model->application_id = $modelApplication->application_id;
                 /*
                  * check if exit
                  */
                $modeledu= Education::find()->where(["registration_number"=>$model->registration_number,'application_id'=>$modelApplication->application_id,'completion_year'=>$model->completion_year])->all(); 
                        if(count($modeledu)>0){
                 \Yii::$app->session->setFlash('errorMessage',"Registration Number already exist");
                   $model->addError('registration_number', "Registration Number already exist");
                    return $this->render('alevel_create', [
                     'model' => $model,
                              ]);
                        }
             
                 if($model->is_necta == 1){
                      $institutioncode = explode(".", $model->registration_number)[0];
            $model->level = 'ALEVEL';
            $toValidate = [
                'registration_number',
                'under_sponsorship',
                'sponsor_proof_document',
                'completion_year',
                'learning_institution_id',
                'is_necta'
            ];
                   }
                 else if($model->is_necta == 2){
                      $institutioncode =NULL;
                  $model->level = 'ALEVEL';
                        $toValidate =[
                            'registration_number',
                            'under_sponsorship',
                            'sponsor_proof_document',
                            'completion_year',
                            'learning_institution_id',
                            'is_necta'
                        ];      
                 }
              else if($model->is_necta == 3){
                   $institutioncode =NULL;
                      $model->level = 'COLLEGE';
                        $toValidate =[
                            'avn_number',
                            'programme_name',
                            'under_sponsorship',
                            'sponsor_proof_document',
                            'completion_year',
                            'learning_institution_id',
                            'is_necta'
                        ];      
                 }
               /*
             * Get Institution Information
             */
           
            $institution_id = $this->getInstitutionId($institutioncode, $model->institution_name);

        
            /*
             * end search institution information
             */
            $model->learning_institution_id = $institution_id;
              if($model->under_sponsorship==1){
                $model->sponsor_proof_document = UploadedFile::getInstance($model, 'sponsor_proof_document');
                if ($model->sponsor_proof_document != "") {
                    $model->sponsor_proof_document->saveAs('applicant_attachment/' . $model->sponsor_proof_document->name);
                    $model->sponsor_proof_document = 'applicant_attachment/' . $model->sponsor_proof_document->name;
                } else {
                    $model->sponsor_proof_document = $model->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $model->sponsor_proof_document=Null;     
                  }
            if ($model->validate($toValidate, false)) {
                if ($model->save(false)) {
                    
                }
                else{
            return $this->render('alevel_create', [
                    'model' => $model,
        ]);         
                }
            }
       return $this->redirect(['alevel-view']);
        }
        return $this->render('alevel_create', [
                    'model' => $model,
        ]);
    }
  public function actionAlevelUpdate($id) {
        $model = Education::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            
            //echo "micki";
           //   exit();
            $user_id = Yii::$app->user->identity->id;
            //$modelUser = \common\models\User::findOne($user_id);
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $model->application_id = $modelApplication->application_id;
               /*
                  * check if exit
                  */
                $modeledu= Education::find()->where(["registration_number"=>$model->registration_number,'application_id'=>$modelApplication->application_id,'completion_year'=>$model->completion_year])->all(); 
                        if(count($modeledu)>0){
                            $test_duplicate=0;
                         foreach($modeledu as $modeledu_test){
                                  if($model->education_id!=$modeledu_test->education_id){
                                $test_duplicate+=1;      
                                  }
                                  
                         }
                         if($test_duplicate>0){
                 \Yii::$app->session->setFlash('errorMessage',"Registration Number already exit");
                   $model->addError('registration_number', "Registration Number already exit");
                    return $this->render('alevel_update', [
                     'model' => $model,
                              ]);
                         }
                        }
                   /*
                    * end 
                    */
                 if($model->is_necta == 1){
                      $institutioncode = explode(".", $model->registration_number)[0];
            $model->level = 'ALEVEL';
            $toValidate = [
                'registration_number',
                'under_sponsorship',
                'sponsor_proof_document',
                'completion_year',
                'learning_institution_id',
                'is_necta'
            ];
                   }
                 else if($model->is_necta == 2){
                      $institutioncode = NULL;
                  $model->level = 'ALEVEL';
                        $toValidate =[
                            'registration_number',
                            'under_sponsorship',
                            'sponsor_proof_document',
                            'completion_year',
                            'learning_institution_id',
                            'is_necta'
                        ];      
                 }
              else if($model->is_necta == 3){
                   $institutioncode = NULL;
                      $model->level = 'COLLEGE';
                        $toValidate =[
                            //'registration_number',
                            'avn_number',
                            'programme_name',
                            'under_sponsorship',
                            'sponsor_proof_document',
                            'completion_year',
                            'learning_institution_id',
                            'is_necta'
                        ];      
                 }
               /*
             * Get Institution Information
             */
           
            $institution_id = $this->getInstitutionId($institutioncode, $model->institution_name);

            /*
             * end search institution information
             */
             $model->learning_institution_id = $institution_id;
            
              if($model->under_sponsorship==1){
                $model->sponsor_proof_document = UploadedFile::getInstance($model, 'sponsor_proof_document');
                if ($model->sponsor_proof_document != "") {
                    $model->sponsor_proof_document->saveAs('applicant_attachment/' . $model->sponsor_proof_document->name);
                    $model->sponsor_proof_document = 'applicant_attachment/' . $model->sponsor_proof_document->name;
                } else {
                    $model->sponsor_proof_document = $model->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $model->sponsor_proof_document=Null;     
                  }
            if ($model->validate($toValidate, false)) {
                if ($model->save(false)) {
                    return $this->redirect(['alevel-view']);
                }
            }
           else{
            return $this->render('alevel_update', [
                    'model' => $model,
        ]);         
                }
        }
        return $this->render('alevel_update', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single Education model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->education_id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Education model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Education;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->education_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Education model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->education_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Education model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $url) {
        $this->findModel($id)->delete();

        return $this->redirect([$url]);
    }

    /**
     * Finds the Education model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Education the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        
       // $model = Education::find()->where(["education_id"=>$id,'application_id'=>Yii::$app->user->identity->id])->One();
        if (($model = Education::findone($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
public function actionCompletionYear() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $year = $parents[0];
                // $out = \common\models\Education::getCompletionyear($loanItemId);

                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }

    /*
     * get or generate instititution Id;
     */

    function getInstitutionId($institution_code, $institution_name) {
        /*
         * find institution Id
         */
        
        $model = LearningInstitution::findOne(["institution_code" => $institution_code]);
        if (count($model) > 0&&$institution_code!="") {
            return $model->learning_institution_id;
        } else {
            $toValidate_app = [
                'institution_name',
                'institution_code',
            ];
            $model_app = new LearningInstitution();
            $model_app->institution_code = $institution_code;
            $model_app->entered_by_applicant = 1;
            $model_app->institution_name = $institution_name;
            if ($model_app->validate($toValidate_app, false)) {
                if ($model_app->save(false)) {
                  return $model_app->learning_institution_id;
                }
            }
        }
    // print_r($model_app->errors);
    /// exit();
    }
    public function actionTlevelView() {
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();

        $model = new Education;
        if ($model->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;
            $modelUser = \common\models\User::findOne($user_id);
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $model->application_id = $modelApplication->application_id;
            //$model->level = 'ALEVEL';

            $toValidate = [
                'registration_number',
                'under_sponsorship',
                'sponsor_proof_document',
                'completion_year',
                'learning_institution_id',
                'is_necta'
            ];
            /*
             * Get Institution Information
             */
            $institutioncode =NULL;
            $institution_id = $this->getInstitutionId($institutioncode, $model->institution_name);

            /*
             * end search institution information
             */
            $model->learning_institution_id = $institution_id;
              if($model->under_sponsorship==1){
                $model->sponsor_proof_document = UploadedFile::getInstance($model, 'sponsor_proof_document');
                if ($model->sponsor_proof_document != "") {
                    $model->sponsor_proof_document->saveAs('applicant_attachment/' . $model->sponsor_proof_document->name);
                    $model->sponsor_proof_document = 'applicant_attachment/' . $model->sponsor_proof_document->name;
                } else {
                    $model->sponsor_proof_document = $model->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $model->sponsor_proof_document=Null;     
                  }
            ##########################admission Letter#####################
                $model->admission_letter = UploadedFile::getInstance($model, 'admission_letter');
                if ($model->admission_letter != "") {
                    $model->admission_letter->saveAs('applicant_attachment/' . $model->admission_letter->name);
                    $model->admission_letter = 'applicant_attachment/' . $model->admission_letter->name;
                } else {
                    $model->admission_letter = $model->OldAttributes['admission_letter'];
                }
           ##############################end admission letter#######################################    
           #######################employer letter   ################################################
                $model->employer_letter = UploadedFile::getInstance($model, 'employer_letter');
                if ($model->employer_letter != "") {
                    $model->employer_letter->saveAs('applicant_attachment/' . $model->employer_letter->name);
                    $model->employer_letter = 'applicant_attachment/' . $model->employer_letter->name;
                } else {
                    $model->employer_letter = $model->OldAttributes['employer_letter'];
                }
           #############################end employer############################################    
            if ($model->validate($toValidate, false)) {
                if ($model->save()) {
                    return $this->redirect(['tlevel-view']);
                }
            }
        }
        return $this->render('tlevel_view', [
                    'modelApplication' => $modelApplication,
                    'modelNew' => $model
        ]);
    }
public function actionTlevelUpdate($id) {
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();

        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;
            $modelUser = \common\models\User::findOne($user_id);
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $model->application_id = $modelApplication->application_id;
            //$model->level = 'ALEVEL';

            $toValidate = [
                'registration_number',
                'under_sponsorship',
                'sponsor_proof_document',
                'completion_year',
                'learning_institution_id',
                'is_necta'
            ];
            /*
             * Get Institution Information
             */
            $institutioncode =NULL;
            $institution_id = $this->getInstitutionId($institutioncode, $model->institution_name);

            /*
             * end search institution information
             */
            $model->learning_institution_id = $institution_id;
              if($model->under_sponsorship==1){
                $model->sponsor_proof_document = UploadedFile::getInstance($model, 'sponsor_proof_document');
                if ($model->sponsor_proof_document != "") {
                    $model->sponsor_proof_document->saveAs('applicant_attachment/' . $model->sponsor_proof_document->name);
                    $model->sponsor_proof_document = 'applicant_attachment/' . $model->sponsor_proof_document->name;
                } else {
                    $model->sponsor_proof_document = $model->OldAttributes['sponsor_proof_document'];
                }
                  }
                  else{
                  $model->sponsor_proof_document=Null;     
                  }
            ##########################admission Letter#####################
                $model->admission_letter = UploadedFile::getInstance($model, 'admission_letter');
                if ($model->admission_letter != "") {
                    $model->admission_letter->saveAs('applicant_attachment/' . $model->admission_letter->name);
                    $model->admission_letter = 'applicant_attachment/' . $model->admission_letter->name;
                } else {
                    $model->admission_letter = $model->OldAttributes['admission_letter'];
                }
           ##############################end admission letter#######################################    
           #######################employer letter   ################################################
                $model->employer_letter = UploadedFile::getInstance($model, 'employer_letter');
                if ($model->employer_letter != "") {
                    $model->employer_letter->saveAs('applicant_attachment/' . $model->employer_letter->name);
                    $model->employer_letter = 'applicant_attachment/' . $model->employer_letter->name;
                } else {
                    $model->employer_letter = $model->OldAttributes['employer_letter'];
                }
           #############################end employer############################################    
            if ($model->validate($toValidate, false)) {
                if ($model->save()) {
                    return $this->redirect(['tlevel-view']);
                }
            }
        }
        return $this->render('tlevel_update', [
                    'modelApplication' => $modelApplication,
                    'modelNew' => $model
        ]);
    }

    /*
     * end find 
     */
}
