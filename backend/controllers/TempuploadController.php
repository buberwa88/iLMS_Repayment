<?php

namespace backend\controllers;

use Yii;
use backend\models\Tempupload;
use backend\models\TempuploadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TempuploadController implements the CRUD actions for Tempupload model.
 */
class TempuploadController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tempupload models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TempuploadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tempupload model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tempupload model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate1()
    {
        //$model = new Tempupload();

        $model=\backend\modules\application\models\Application::find()->all();
        foreach ($model as $models){
            //find the loan item
            $loanItem=  \backend\modules\allocation\models\LoanItem::find()->all();
            foreach ($loanItem as  $loanItem){
         $model22=new \backend\modules\allocation\models\Allocation();
            $model22->allocation_batch_id=3;
            $model22->application_id=$models["application_id"];
            $model22->loan_item_id=$loanItem["loan_item_id"];
            $model22->allocated_amount=$loanItem["day_rate_amount"];
         $model22->save();
            }
        }
       /* if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        */
    }

    /**
     * Updates an existing Tempupload model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tempupload model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tempupload model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tempupload the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tempupload::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
   public function actionCreate()
    {
        $model = new Tempupload();

        if ($model->load(Yii::$app->request->post())) {
                   $model->file= \yii\web\UploadedFile::getInstance($model,'file');
                 //if($model->t!=""){
                    $model->file->saveAs('upload/'.$model->file->name);                  
                    $model->file='upload/'.$model->file->name;
                    $data = \moonland\phpexcel\Excel::widget([
                        'mode' => 'import', 
                        'fileName' => $model->file, 
                        'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                        'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                        //'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                    ]);
               
                 foreach ($data as $datas){
                                          /*$name= explode(',', $datas["NAME"]);
                                          print_r($name);
                                         // exit();
                                             $surname=$name[0];
                                             $lastfinal=explode(" ", $name[1]);
                                             print_r($lastfinal);
                                              if(count($lastfinal)==3){
                                                $firstname=@$lastfinal[1]; 
                                                $middlename=@$lastfinal[2]; 
                                               }
                                               else{
                                                 $firstname=@$name[1];
                                                 $middlename="";
                                               }
                                               $email=$datas["INDEXNO"]."@mickidadi.com";
                                               $password='admin@2017';
                                    $modeluser =new \common\models\User();
                                            $modeluser->firstname =$firstname;
                                            $modeluser->middlename =$middlename;
                                            $modeluser->surname =$surname;
                                            $modeluser->username=$datas["INDEXNO"];
                                            $modeluser->email_address=$email;
                                            $modeluser->setPassword($password);
                                            $modeluser->generateAuthKey();
                                     $modeluser->save();
                                   //  print_r($modeluser);
                                     //exit();
                                       /* $user = new User();
                                            $user->firstname = $this->firstname;
                                            $user->middlename = $this->middlename;
                                            $user->surname = $this->surname;
                                            $user->sex = $this->sex;
                                            $user->username = $this->username;
                                            $user->email_address = $this->email_address;
                                            $user->setPassword($this->password);
                                            $user->generateAuthKey();
                                       $user->save();*/
                                  $ucodep=$datas["CENTRENO"];
                                  $usearch= \backend\modules\allocation\models\LearningInstitution::findOne(["institution_code"=>$ucodep]);
                              if(count($usearch)==0){
                        $model12 = new \backend\modules\allocation\models\LearningInstitution();
                              $model12->institution_type="SECONDARY";
                              $model12->institution_name=$datas["SCHOOLNAME"];
                              $model12->institution_code=$datas["CENTRENO"];
                              $model12->ward_id=1;
                              $model12->bank_id=1;
                              $model12->created_by=1;
                        $model12->save();
                            $uId=$model12->learning_institution_id;
                                       }
                                       else{
                              $uId=$usearch->learning_institution_id;         
                                       }
                                    //   print_r($usearch);
                       $model1 = new \backend\modules\allocation\models\LearningInstitutionFee();
                              $model1->learning_institution_id=$uId;
                              $model1->academic_year_id=1;
                              $model1->annual_fee=  str_replace(',', '', $datas["FEE"]);
                             // $model1->has_transfered=0;
                        $model1->save();
//                        print_r($model1);
//                        exit();
//                                     //check if exit 
//                                            $codep=$datas["COURSE"];
//                                  $prosearch=  \backend\modules\application\models\Programme::findOne(["programme_code"=>$codep]);
//                                       if(count($prosearch)==0){
//                         $model11 = new \backend\modules\application\models\Programme();
//                              $model11->learning_institution_id=$uId;
//                              $model11->programme_code=$datas["COURSE"];
//                              $model11->programme_name=$datas["COURSE"];
//                              $model11->years_of_study=$datas["YOS"];
//                         $model11->save();
//                                  $programId=$model11->programme_id;
//                                       }
//                                       else{
//                                  $programId=$prosearch->programme_id;         
//                                       }
//                        

                        
                       
                      
                    } 
                   
                   // }
                     //exit();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
 public function actionUpdateall() {
  $sql="SELECT * FROM admitted_student ad,applicant ap WHERE ad.f4indexno=ap.f4indexno";
  $data = \Yii::$app->db->createCommand($sql)->queryAll();
  foreach ($data as $datas){
                       $applicant_id=$datas["applicant_id"];
   $update= \backend\modules\application\models\Application::findOne(["applicant_id"=>$applicant_id]); 
   $update->programme_id=$datas["programme_id"];
   $update->update();
  }
  }
}
