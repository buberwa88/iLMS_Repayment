<?php

namespace frontend\modules\application\controllers;

use Yii;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\ApplicantAssociateSearch;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Guardian;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use frontend\modules\application\models\Guarantor;

/**
 * ApplicantAssociateController implements the CRUD actions for ApplicantAssociate model.
 */
class ApplicantAssociateController extends Controller {

    /**
     * @inheritdoc
     */
    public $layout = "main_public_beneficiary";

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'parent-delete' => ['POST'],
                    'guarantor-delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ApplicantAssociate models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ApplicantAssociateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ApplicantAssociate model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionParentView() {
        $id = 9;
        $user_id = Yii::$app->user->identity->user_id;
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();

        $modelNew = new ApplicantAssociate();

        if (Yii::$app->request->post()) {
            $modelNew->load(Yii::$app->request->post());
            $modelNew->application_id = $modelApplication->application_id;


            #########@@ start birth_certificate_document #################
            $modelNew->death_certificate_document = UploadedFile::getInstance($modelNew, 'death_certificate_document');
            if ($modelNew->death_certificate_document != "") {
                $modelNew->death_certificate_document->saveAs('applicant_attachment/' . $modelNew->death_certificate_document->name);
                $modelNew->death_certificate_document = 'applicant_attachment/' . $modelNew->death_certificate_document->name;
                ############## birth_certificate_document ###############
            } else {
                $modelNew->death_certificate_document = $modelNew->OldAttributes['death_certificate_document'];
            }
            #########@@ start disability_document #################
            $modelNew->disability_document = UploadedFile::getInstance($modelNew, 'disability_document');
            if ($modelNew->disability_document != "") {
                $modelNew->disability_document->saveAs('applicant_attachment/' . $modelNew->disability_document->name);
                $modelNew->disability_document = 'applicant_attachment/' . $modelNew->disability_document->name;
                ############## disability_document ###############
            } else {
                $modelNew->disability_document = $modelNew->OldAttributes['disability_document'];
            }
            if($modelNew->save()){
                    //success message    
            }
           else{
        return $this->render('parent-view', [
                        'modelApplication' => $modelApplication,
                        'modelNew' => $modelNew,
                        'sectionId' => $id
            ]);          
           }

            return $this->redirect(['parent-view']);
        } else {
            return $this->render('parent-view', [
                        'modelApplication' => $modelApplication,
                        'modelNew' => $modelNew,
                        'sectionId' => $id
            ]);
        }
    }

    public function actionGuardianView() {
        $user_id = Yii::$app->user->identity->user_id;
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();

        $modelNew = new Guardian();

        if ($modelNew->load(Yii::$app->request->post())) {
            $modelNew->application_id = $modelApplication->application_id;
            ######################Update information if parent is the same as parent
            #@@@@@@@@@@@@@@@@@@@@@  start @@@@@@@@@@@@@@@@@@@@@@@@@#
            $modelNew->learning_institution_id = NULL;
            if ($modelNew->having_guardian == "YES") {
                $modelparent = ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' AND sex='M' AND is_parent_alive='YES' AND guarantor_type is NULL")->one();
                $parent_count = 0;
                if (count($modelparent) == 0) {
                    $parent_count = 1;
                    $modelparent = ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' AND sex='F' AND is_parent_alive='YES' AND guarantor_type is NULL")->one();
                    if (count($modelparent) == 0) {
                        $parent_count+=1;
                    }
                }
                if ($parent_count < 2) {
                    $modelNew->is_parent_alive = $modelparent->is_parent_alive;
                    $modelNew->disability_status = $modelparent->disability_status;
                    $modelNew->firstname = $modelparent->firstname;
                    $modelNew->middlename = $modelparent->middlename;
                    $modelNew->	occupation_id=$modelparent->occupation_id;
                    $modelNew->physical_address=$modelparent->physical_address;
                    $modelNew->email_address=$modelparent->email_address;
                    $modelNew->surname = $modelparent->surname;
                    $modelNew->phone_number = $modelparent->phone_number;
                    $modelNew->postal_address = $modelparent->postal_address;
                    $modelNew->physical_address = $modelparent->physical_address;
                    $modelNew->sex = $modelparent->sex;
                     $modelNew->ward_id=$modelparent->ward_id; 
                    $modelNew->learning_institution_id = NULL;
                    $modelNew->application_id = $modelApplication->application_id;

                    Yii::$app->getSession()->setFlash('success', "Data Saved successfully");
                } else {
                    Yii::$app->getSession()->setFlash('warning', "Sorry ! No parent Information or your parent are not alive ");
                    return $this->redirect(['guardian-view']);
                }
            }
            
            #######################end transaction ###################
            #@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@#
              if($modelNew->save()){
                
              }
              else{
            return $this->render('guardian-view', [
                        'modelApplication' => $modelApplication,
                        'modelNew' => $modelNew
            ]);      
              }
             //print_r($modelNew->geterrors());
            //  exit();
            return $this->redirect(['guardian-view']);
        } else {
            return $this->render('guardian-view', [
                        'modelApplication' => $modelApplication,
                        'modelNew' => $modelNew
            ]);
        }
    }
   public function actionGuardianUpdate($id) {
        $modelNew = Guardian::findOne($id);
        if ($modelNew->load(Yii::$app->request->post())) {
              $modelNew->learning_institution_id = NULL;
            if ($modelNew->having_guardian == "YES") {
                $modelparent = ApplicantAssociate::find()->where("application_id = {$modelNew->application_id} AND type = 'PR' AND sex='M' AND is_parent_alive='YES' AND guarantor_type is NULL")->one();
                $parent_count = 0;
                if (count($modelparent) == 0) {
                    $parent_count = 1;
                    $modelparent = ApplicantAssociate::find()->where("application_id = {$modelNew->application_id} AND type = 'PR' AND sex='F' AND is_parent_alive='YES' AND guarantor_type is NULL")->one();
                    if (count($modelparent) == 0) {
                        $parent_count+=1;
                    }
                }
                if ($parent_count < 2) {
                    $modelNew->is_parent_alive = $modelparent->is_parent_alive;
                    $modelNew->disability_status = $modelparent->disability_status;
                    $modelNew->firstname = $modelparent->firstname;
                    $modelNew->middlename = $modelparent->middlename;
                    $modelNew->	occupation_id=$modelparent->occupation_id;
                    $modelNew->physical_address=$modelparent->physical_address;
                    $modelNew->email_address=$modelparent->email_address;
                    $modelNew->surname = $modelparent->surname;
                    $modelNew->phone_number = $modelparent->phone_number;
                    $modelNew->postal_address = $modelparent->postal_address;
                    $modelNew->physical_address = $modelparent->physical_address;
                    $modelNew->sex = $modelparent->sex;
                     $modelNew->ward_id=$modelparent->ward_id; 
                    $modelNew->learning_institution_id = NULL;
                    $modelNew->application_id = $modelNew->application_id;
                  //  $modelNew->save();
            #######################end transaction ###################
            #@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@#
              if($modelNew->save()){
                
              }
              else{
            return $this->render('guardian-view', [
                        //'modelApplication' => $modelApplication,
                        'modelNew' => $modelNew
            ]);      
              }
          Yii::$app->getSession()->setFlash('success', "Data Saved successfully");
                } else {
                    Yii::$app->getSession()->setFlash('warning', "Sorry ! No parent Information or your parent are not alive ");
                    return $this->redirect(['guardian-view']);
                }
            }
            return $this->redirect(['guardian-view']);
        } else {
            return $this->render('update_guardian', [
                        'model' => $modelNew,
            ]);
        }
    }

    /**
     * Creates a new ApplicantAssociate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ApplicantAssociate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['parent-view', 'id' => $model->applicant_associate_id]);
        } else {
            return $this->render('create_parent', [
                        'model' => $model,
            ]);
        }
    }

    public function actionParentCreate() {
        $modelNew = new ApplicantAssociate();

        if ($modelNew->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $modelNew->application_id = $modelApplication->application_id;
            #########@@ start birth_certificate_document #################
            $modelNew->death_certificate_document = UploadedFile::getInstance($modelNew, 'death_certificate_document');
            if ($modelNew->death_certificate_document != "") {
                $modelNew->death_certificate_document->saveAs('applicant_attachment/' . $modelNew->death_certificate_document->name);
                $modelNew->death_certificate_document = 'applicant_attachment/' . $modelNew->death_certificate_document->name;
                ############## birth_certificate_document ###############
            } else {
                $modelNew->death_certificate_document = $modelNew->OldAttributes['death_certificate_document'];
            }
            #########@@ start disability_document #################
            $modelNew->disability_document = UploadedFile::getInstance($modelNew, 'disability_document');
            if ($modelNew->disability_document != "") {
                $modelNew->disability_document->saveAs('applicant_attachment/' . $modelNew->disability_document->name);
                $modelNew->disability_document = 'applicant_attachment/' . $modelNew->disability_document->name;
                ############## disability_document ###############
            } else {
                $modelNew->disability_document = $modelNew->OldAttributes['disability_document'];
            }
            $modelNew->save();
            return $this->redirect(['parent-view']);
        } else {
            return $this->render('create_parent', [
                        'model' => $modelNew,
            ]);
        }
    }

    /**
     * Updates an existing ApplicantAssociate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->applicant_associate_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionParentUpdate($id) {
        $modelNew = $this->findModel($id);

        if ($modelNew->load(Yii::$app->request->post())) {

            #########@@ start birth_certificate_document #################
            if ($modelNew->is_parent_alive == "NO") {
                //
                    //enddelete all information of applicant associate
                    Yii::$app->db->createCommand("DELETE FROM `applicant_associate` WHERE application_id='{$modelNew->application_id}' AND type <>'PR' AND sex='{$modelNew->sex}'")->execute();           
                            
                    //end 
                ###########cleaning###########
                $modelNew->disability_status = NULL;
                $modelNew->firstname = NULL;
                $modelNew->middlename = NULL;
                $modelNew->surname = NULL;
                $modelNew->phone_number = NULL;
                $modelNew->postal_address = NULL;
                $modelNew->physical_address = NULL;
                //$modelNew->sex=NULL;
                $modelNew->disability_document = NULL;
                $modelNew->email_address = NULL;
                $modelNew->ward_id = NULL;
                $modelNew->occupation_id = NULL;
                $modelNew->disability_document=NULL;
                ############end##############
                $modelNew->death_certificate_document = UploadedFile::getInstance($modelNew, 'death_certificate_document');
                if ($modelNew->death_certificate_document != "") {
                    $modelNew->death_certificate_document->saveAs('applicant_attachment/' . $modelNew->death_certificate_document->name);
                    $modelNew->death_certificate_document = 'applicant_attachment/' . $modelNew->death_certificate_document->name;
                    ############## birth_certificate_document ###############
                } else {
                    $modelNew->death_certificate_document = $modelNew->OldAttributes['death_certificate_document'];
                }
            } else {
                $modelNew->death_certificate_number = NULL;
                $modelNew->death_certificate_document = NULL;
                #########@@ start disability_document #################
                $modelNew->disability_document = UploadedFile::getInstance($modelNew, 'disability_document');
                if ($modelNew->disability_document != "") {
                    $modelNew->disability_document->saveAs('applicant_attachment/' . $modelNew->disability_document->name);
                    $modelNew->disability_document = 'applicant_attachment/' . $modelNew->disability_document->name;
                    ############## disability_document ###############
                } else {
                        if($modelNew->disability_status=="YES"){
                    $modelNew->disability_document = $modelNew->OldAttributes['disability_document'];
                        }
                }
            }
               if($modelNew->save()){
                   
               }
               else {
               return $this->render('update_parent', [
                        'model' => $modelNew,
            ]);     
               }
            return $this->redirect(['parent-view']);
        } else {
            return $this->render('update_parent', [
                        'model' => $modelNew,
            ]);
        }
    }

    /**
     * Deletes an existing ApplicantAssociate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionGuardianCreate() {
        $model = new ApplicantAssociate();

        if ($model->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $model->application_id = $modelApplication->application_id;
            $model->save();
            return $this->redirect(['guardian-view']);
        } else {
            return $this->render('create_guardian', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Finds the ApplicantAssociate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ApplicantAssociate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ApplicantAssociate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGuarantorView() {
        $user_id = Yii::$app->user->identity->user_id;
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();

            $model = new Guarantor();

        if ($model->load(Yii::$app->request->post())) {
         
            if ($model->load(Yii::$app->request->post())) {
                ############# delete all guarantor #############
                // Yii::$app->db->createCommand("delete  from applicant_associate where application_id = '{$modelApplication->application_id}' AND type='GA'")->execute();
                ###@@@@@@@@@@@ end delete @@@@@@@@@############
                if ($model->guarantor_type == 1 && $model->organization_type>1) {
                    $model->learning_institution_id = NULL;
                } else if ($model->guarantor_type == 2 || $model->guarantor_type == 3) {
                    $model->learning_institution_id = NULL;
                    if ($model->guarantor_type == 2) {
                        $sex = 'M';
                    } else {
                        $sex = 'F';
                    }
                   // echo $modelApplication->application_id." gender ".$sex;
                    
                    $modelparent = ApplicantAssociate::find()->where("application_id ='{$modelApplication->application_id}' AND is_parent_alive='YES' AND  sex ='{$sex}' AND type='PR' AND guarantor_type is NULL")->one();
                  //  print_r($modelparent);
                 //  echo $modelparent->firstname;
                   //  exit();
                    if (count($modelparent) > 0) {
                        $model->is_parent_alive = $modelparent->is_parent_alive;
                        $model->disability_status = $modelparent->disability_status;
                        $model->firstname = $modelparent->firstname;
                        $model->middlename = $modelparent->middlename;
                        $model->surname = $modelparent->surname;
                        $model->phone_number = $modelparent->phone_number;
                        $model->postal_address = $modelparent->postal_address;
                        $model->physical_address = $modelparent->physical_address;
                        $model->email_address = $modelparent->email_address;
                        $model->occupation_id = $modelparent->occupation_id;
                        $model->ward_id = $modelparent->ward_id;
                        $model->sex = $modelparent->sex;
                        $model->organization_type = NULL;
                        $model->learning_institution_id = NULL;
                        $model->passport_photo = UploadedFile::getInstance($model, 'passport_photo');
                        if($model->passport_photo != "") {
                            $model->passport_photo->saveAs('applicant_attachment/profile/' . $model->passport_photo->name);
                            $model->file_path = 'applicant_attachment/profile/';
                            $model->passport_photo = $model->passport_photo->name;
                        }
                        #########@@ start identification_document #################
                        $model->identification_document = UploadedFile::getInstance($model, 'identification_document');
                        
                        if ($model->identification_document != "") {
                            $model->identification_document->saveAs('applicant_attachment/' . $model->identification_document->name);
                            $model->identification_document = 'applicant_attachment/' . $model->identification_document->name;
                            ############## identification_document ###############
                        }
                       $model->application_id = $modelApplication->application_id;
                         $model->save();
//                         print_r($model->errors);
//                           exit();
////                 
                        Yii::$app->getSession()->setFlash('success', "Data Saved successfully");
                    } else {
                        Yii::$app->getSession()->setFlash('warning', "Sorry ! No parent Information or your parent are not alive ");
                        return $this->redirect(['guarantor-view']);
                    }
                } else if ($model->guarantor_type == 4) {
                    $model->learning_institution_id = NULL;
                    $modelparent = ApplicantAssociate::find()->where(["application_id" => $modelApplication->application_id, 'type' => "GD"])->one();
//                     print_r($modelparent);
//                     exit();
                    if (count($modelparent) > 0 && $modelparent->firstname != "") {
                        $model->is_parent_alive = $modelparent->is_parent_alive;
                        $model->disability_status = $modelparent->disability_status;
                        $model->firstname = $modelparent->firstname;
                        $model->middlename = $modelparent->middlename;
                        $model->surname = $modelparent->surname;
                        $model->phone_number = $modelparent->phone_number;
                        $model->postal_address = $modelparent->postal_address;
                        $model->physical_address = $modelparent->physical_address;
                        $model->email_address = $modelparent->email_address;
                        $model->ward_id = $modelparent->ward_id;
                        $model->occupation_id = $modelparent->occupation_id;
                        $model->sex = $modelparent->sex;
                        $model->organization_type = NULL;
                        $model->learning_institution_id = NULL;
                        $model->passport_photo = UploadedFile::getInstance($model, 'passport_photo');
                        if ($model->passport_photo != "") {
                            $model->passport_photo->saveAs('applicant_attachment/profile/' . $model->passport_photo->name);
                            $model->file_path = 'applicant_attachment/profile/';
                            $model->passport_photo = $model->passport_photo->name;
                        } else {
                            $model->passport_photo = $model->OldAttributes['passport_photo'];
                        }
                        #########@@ start identification_document #################
                        $model->identification_document = UploadedFile::getInstance($model, 'identification_document');
                        //var_dump($modelall);die();
                        if ($model->identification_document != "") {
                            $model->identification_document->saveAs('applicant_attachment/' . $model->identification_document->name);
                            $model->identification_document = 'applicant_attachment/' . $model->identification_document->name;
                            ############## identification_document ###############
                        } else {
                            $model->identification_document = $model->OldAttributes['identification_document'];
                        }
                        Yii::$app->getSession()->setFlash('success', "Data Saved successfully");
                    } else {
                        Yii::$app->getSession()->setFlash('warning', "Sorry ! No Guardian Information  ");
                        return $this->redirect(['guarantor-view']);
                    }
                }
                $model->application_id = $modelApplication->application_id;
                  if($model->save()){
                  ##############display success message @@@@@@@@@#############
                      
                  ##################end #######################@@@@@@########
                  }
                  else{
               return $this->render('guarantor-view', [
                        'modelApplication' => $modelApplication,
                        'modelNew' => $model
            ]);        
                  }
                ####################new update @@@@@@@@@@@############
            }
//            print_r($model->errors);
//            exit();
            return $this->redirect(['guarantor-view']);
        } else {
            return $this->render('guarantor-view', [
                        'modelApplication' => $modelApplication,
                        'modelNew' => $model
            ]);
        }
    }

    public function actionGuarantorCreate() {
        $model = new ApplicantAssociate();

        if ($model->load(Yii::$app->request->post())) {
            $user_id = Yii::$app->user->identity->id;
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
            $model->application_id = $modelApplication->application_id;
            $model->save();
            return $this->redirect(['guarantor-view']);
        } else {
            return $this->render('create_guarantor', [
                        'model' => $model,
            ]);
        }
    }

    public function actionParentQuestion() {

        $user_id = Yii::$app->user->identity->user_id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = \frontend\modules\application\models\Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
        if (!empty($_POST)) {

            Yii::$app->db->createCommand("delete  from applicant_question where application_id = {$modelApplication->application_id}")->execute();
            foreach ($_POST['question_id'] as $key => $question_id) {
                $modelQn = \backend\modules\application\models\Question::findOne($question_id);
                $modelAppQn = new ApplicantQuestion();
                $modelAppQn->question_id = $question_id;
                $modelAppQn->application_id = $modelApplication->application_id;
                $modelAppQn->save(false);

                if (!is_array($_POST['control_name_' . $question_id])) {
                    $modelAppRes = new ApplicantQnResponse;
                    $modelAppRes->applicant_question_id = $modelAppQn->applicant_question_id;
                    $modelAppRes->qresponse_source_id = 1;

                    if ($modelQn->response_control == 'TEXTBOX') {
                        $modelAppRes->question_answer = $_POST['control_name_' . $question_id];
                    } else {
                        $modelAppRes->response_id = $_POST['control_name_' . $question_id];
                    }
                    $modelAppRes->save(false);
                } else {
                    foreach ($_POST['control_name_' . $question_id] as $k => $v) {
                        $modelAppRes = new ApplicantQnResponse;
                        $modelAppRes->applicant_question_id = $modelAppQn->applicant_question_id;
                        $modelAppRes->qresponse_source_id = 1;
                        $modelAppRes->response_id = $v;
                        $modelAppRes->save(false);
                    }
                }
            }
        }

//        $query = "insert into applicant_question(application_id, question_id) select {$modelApplication->application_id}, question.question_id from question inner join section_question on section_question.question_id = question.question_id inner join applicant_category_section on applicant_category_section.applicant_category_section_id = section_question.applicant_category_section_id where applicant_category_section.applicant_category_id = 1 "
//        . " AND question.question_id NOT IN (select question_id from applicant_question where application_id = {$modelApplication->application_id})";
//        Yii::$app->db->createCommand($query)->execute();

        return $this->render('application_questions', ['application_id' => $modelApplication->application_id]);
    }

    public function actionGuarantorUpdate($id) {
        $model = Guarantor::findone($id);
        $user_id = Yii::$app->user->identity->user_id;
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();

        if ($model->load(Yii::$app->request->post())) {
            ############# delete all guarantor #############
            // Yii::$app->db->createCommand("delete  from applicant_associate where application_id = '{$modelApplication->application_id}' AND type='GA'")->execute();
            ###@@@@@@@@@@@ end delete @@@@@@@@@############
            if ($model->guarantor_type == 1 && $model->organization_type >1) {
                $model->learning_institution_id = NULL;
            } else if ($model->guarantor_type == 2 || $model->guarantor_type == 3) {
                $model->learning_institution_id = NULL;
                if ($model->guarantor_type == 2) {
                    $sex = 'M';
                } else {
                    $sex = 'F';
                }
                $modelparent = ApplicantAssociate::find()->where(["application_id" => $model->application_id, 'is_parent_alive' => "YES", 'sex' => $sex, 'type' => "PR"])->one();

                if (count($modelparent) > 0) {
                    $model->is_parent_alive = $modelparent->is_parent_alive;
                    $model->disability_status = $modelparent->disability_status;
                    $model->firstname = $modelparent->firstname;
                    $model->middlename = $modelparent->middlename;
                    $model->surname = $modelparent->surname;
                    $model->phone_number = $modelparent->phone_number;
                    $model->physical_address = $modelparent->physical_address;
                    $model->email_address = $modelparent->email_address;
                    $model->postal_address = $modelparent->postal_address;
                    $model->occupation_id = $modelparent->occupation_id;
                    $model->ward_id = $modelparent->ward_id;
                    $model->sex = $modelparent->sex;
                    $model->organization_type = NULL;
                    $model->learning_institution_id = NULL;
                    $model->passport_photo = UploadedFile::getInstance($model, 'passport_photo');


                    if ($model->passport_photo != "") {
                        $model->passport_photo->saveAs('applicant_attachment/profile/' . $model->passport_photo->name);
                        $model->file_path = 'applicant_attachment/profile/';
                        $model->passport_photo = $model->passport_photo->name;
                    } else {
                        $model->passport_photo = $model->OldAttributes['passport_photo'];
                    }
                    #########@@ start identification_document #################
                    $model->identification_document = UploadedFile::getInstance($model, 'identification_document');
                    //var_dump($modelall);die();
                    if ($model->identification_document != "") {
                        $model->identification_document->saveAs('applicant_attachment/' . $model->identification_document->name);
                        $model->identification_document = 'applicant_attachment/' . $model->identification_document->name;
                        ############## identification_document ###############
                    } else {
                        $model->identification_document = $model->OldAttributes['identification_document'];
                    }
                    $model->save();
//                echo $model->passport_photo;
                    //      print_r($model);
                    //   exit();
                    Yii::$app->getSession()->setFlash('success', "Data Saved successfully");
                } else {
                    Yii::$app->getSession()->setFlash('warning', "Sorry ! No parent Information or your parent are not alive ");
                    return $this->redirect(['guarantor-view']);
                }
            } else if ($model->guarantor_type == 4) {
                $model->learning_institution_id = NULL;
                $modelparent = ApplicantAssociate::find()->where(["application_id" => $model->application_id, 'type' => "GD"])->one();

                if (count($modelparent) > 0 && $modelparent->firstname != "") {
                    $model->is_parent_alive = $modelparent->is_parent_alive;
                    $model->disability_status = $modelparent->disability_status;
                    $model->firstname = $modelparent->firstname;
                    $model->middlename = $modelparent->middlename;
                    $model->surname = $modelparent->surname;
                    $model->phone_number = $modelparent->phone_number;
                    $model->postal_address = $modelparent->postal_address;
                    $model->physical_address = $modelparent->physical_address;
                    $model->email_address = $modelparent->email_address;
                    $model->ward_id = $modelparent->ward_id;
                    $model->occupation_id = $modelparent->occupation_id;
                    $model->sex = $modelparent->sex;
                    $model->organization_type = NULL;
                    $model->learning_institution_id = NULL;
                    $model->passport_photo = UploadedFile::getInstance($model, 'passport_photo');
                    if ($model->passport_photo != "") {
                        $model->passport_photo->saveAs('applicant_attachment/profile/' . $model->passport_photo->name);
                        $model->file_path = 'applicant_attachment/profile/';
                        $model->passport_photo = $model->passport_photo->name;
                    } else {
                        $model->passport_photo = $model->OldAttributes['passport_photo'];
                    }
                    #########@@ start identification_document #################
                    $model->identification_document = UploadedFile::getInstance($model, 'identification_document');
                    //var_dump($modelall);die();
                    if ($model->identification_document != "") {
                        $model->identification_document->saveAs('applicant_attachment/' . $model->identification_document->name);
                        $model->identification_document = 'applicant_attachment/' . $model->identification_document->name;
                        ############## identification_document ###############
                    } else {
                        $model->identification_document = $model->OldAttributes['identification_document'];
                    }
                    Yii::$app->getSession()->setFlash('success', "Data Saved successfully");
                } else {
                    Yii::$app->getSession()->setFlash('warning', "Sorry ! No Guardian Information  ");
                    return $this->redirect(['guarantor-view']);
                }
            }
             if($model->save()){
                  ##############display success message @@@@@@@@@#############
                      
                  ##################end #######################@@@@@@########
                  }
                  else{
               return $this->render('guarantor-view', [
                        'modelApplication' => $modelApplication,
                        'modelNew' => $model
            ]);        
                  }

            return $this->redirect(['guarantor-view']);
        } else {
            return $this->render('update_guarantor', [
                        'model' => $model,
                        'modelApplication' => $modelApplication,
            ]);
        }
    }

    public function actionDelete($id, $url) {
        $this->findModel($id)->delete();

        return $this->redirect(["$url"]);
    }

    public function actionGuarantorDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['guarantor-view']);
    }

    public function actionParentDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['parent-view']);
    }

}
