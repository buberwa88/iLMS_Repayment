<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\Programme;
use backend\modules\allocation\models\ProgrammeSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use common\components\Controller;
use yii\web\Controller;
use backend\modules\allocation\models\LoanItem;
use \backend\modules\allocation\models\ProgrammeCost;
use backend\modules\allocation\models\base\LearningInstitution;
use yii\web\UploadedFile;
use backend\modules\allocation\models\ProgrammeLoanItemCost;
use backend\modules\allocation\models\Model;
use backend\modules\allocation\models\base\LearningInstitutionFee;

/**
 * ProgrammeController implements the CRUD actions for Programme model.
 */
class ProgrammeController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $this->layout = "main_private";
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
     * Lists all Programme models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProgrammeSearch();
        $dataProviderActive = $searchModel->searchCriteriaBases(Yii::$app->request->queryParams, $status = 1);
        $dataProviderInActive = $searchModel->searchCriteriaBases(Yii::$app->request->queryParams, $status = 0);
        $dataProviderClosed = $searchModel->searchCriteriaBases(Yii::$app->request->queryParams, $status = 2);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProviderActive' => $dataProviderActive,
                    'dataProviderInActive' => $dataProviderInActive,
                    'dataProviderClosed' => $dataProviderClosed,
        ]);
    }

    public function actionProgrammeList() {
        $searchModel = new ProgrammeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('programmeslist', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Programme model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $programme_costs = new \backend\modules\allocation\models\ProgrammeCostSearch();
        $programme_costs->programme_id = $model->programme_id;
        $dataProvider = $programme_costs->searchByProgramme(Yii::$app->request->queryParams, $programme_costs->programme_id);

        return $this->render('view', [
                    'model' => $model, 'programme_costs' => $programme_costs, 'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Programme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Programme();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                    'success', 'Data Successfully Created!'
            );
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Programme model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                    'success', 'Data Successfully Updated!'
            );
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Programme model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Programme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Programme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Programme::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetprogrammename() {

        $out = [];
        //$programme_category_id=2;
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $academic_year = $parents[0];
                $programme_category_id = implode(',', $parents[1]);
                $out = Programme::getprogrammeName($programme_category_id, $academic_year);

                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }

    /**
     * Creates a new ProgrammeFee model. based on the pprogramme selected
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*
      public function actionCost($id) {
      $model = $this->findModel($id); //getting the programme model
      $cost = new ProgrammeCost;
      $cost->programme_id = $model->programme_id;
      $model_cost = [ new ProgrammeCost];
      //getting programme Country of study to determine the LoanItems to retrieve based on the country
      $programme_country_of_study = $model->learningInstitution->country;
      $programme_group = $model->programmeGroup;
      ////Setting Item Category based on the country of study of the programme
      $cost->item_category = ($programme_country_of_study == 'TZ' OR $programme_country_of_study == 'TZA') ? LoanItem::ITEM_CATEGORY_NORMAL : LoanItem::ITEM_CATEGORY_SCHOLARSHIP;

      if (Yii::$app->request->post('ProgrammeCost')) {
      $post_data = Yii::$app->request->post('ProgrammeCost');
      $count = count($post_data);
      //validating the data received
      if ($count) {
      //                $valid_entry = 0;
      $valid_models = array();
      $academic_year = $post_data['academic_year_id'];
      $year_of_study = $post_data['year_of_study'];
      $loan_items = $post_data['loan_item_id'];
      $rate_type = $post_data['rate_type'];
      $unit_amount = $post_data['unit_amount'];
      $duration = $post_data['duration'];
      foreach ($loan_items as $key => $data) {
      $validation_model = new ProgrammeCost;
      $validation_model->programme_id = $model->programme_id;
      $validation_model->academic_year_id = $academic_year;
      $validation_model->year_of_study = $year_of_study;
      $validation_model->loan_item_id = $data;
      $validation_model->rate_type = $rate_type[$key];
      $validation_model->unit_amount = $unit_amount[$key];
      $validation_model->duration = $duration[$key];
      if ($validation_model->validate()) {
      array_push($valid_models, $validation_model);
      } else {
      var_dump($validation_model->errors);
      }
      }
      //var_dump($valid_models);
      //exit;
      ///end validation
      if (count($valid_models)) {
      $transaction = \Yii::$app->db->beginTransaction();
      try {
      $failure = 0;
      //loopng  through thr valid mode to save each
      foreach ($valid_models as $key => $valid_model) {
      if (!$valid_model->save()) {
      $failure++;
      }
      }
      if ($failure) {
      $transaction->rollBack();
      } else {
      $transaction->commit();
      return $this->redirect(['view', 'id' => $model->programme_id]);
      }
      } catch (Exception $e) {
      $transaction->rollBack();
      }
      }
      }
      }
      return $this->render('add_cost', [
      'model' => $model,
      'cost' => $cost,
      'model_cost' => (empty($model_cost)) ? [new \backend\modules\allocation\models\ProgrammeCost] : $model_cost
      ]);
      }
     */



    public function actionCost($id) {
        $model = $this->findModel($id); //getting the programme model
        //$cost->programme_id = $model->programme_id;

        $modelProgrammeLoanItemCost = new ProgrammeLoanItemCost;
        $modelProgrammeLoanItemCost->scenario = 'programme_loan_item_cost_add';
        $ProgrammeCost = [new ProgrammeCost];
        if ($modelProgrammeLoanItemCost->load(Yii::$app->request->post()) && $modelProgrammeLoanItemCost->validate()) {

            $ProgrammeCost = Model::createMultiple(ProgrammeCost::classname());
            Model::loadMultiple($ProgrammeCost, Yii::$app->request->post());
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $i = 1;

                $programme_country_of_study = $model->learningInstitution->country;
                $programme_group = $model->programmeGroup;

                foreach ($ProgrammeCost as $ProgrammeCost2) {
                    $programme_id = $ProgrammeCost2->programme_id = $modelProgrammeLoanItemCost->programme_id;
                    $academic_year_id = $ProgrammeCost2->academic_year_id = $modelProgrammeLoanItemCost->academic_year_id;
                    $year_of_study = $ProgrammeCost2->year_of_study = $modelProgrammeLoanItemCost->year_of_study;
                    $programme_type = $ProgrammeCost2->programme_type = "0";
                    $loan_item_id = $ProgrammeCost3->loan_item_id = $ProgrammeCost2->loan_item_id;
                    $unit_amount = $ProgrammeCost3->unit_amount = $ProgrammeCost2->unit_amount;
                    $duration = $ProgrammeCost3->duration = $ProgrammeCost2->duration;
                    $i++;

                    if (!($flag = $ProgrammeCost2->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }

                if ($flag) {
                    $transaction->commit();
                    $sms = "Information successful added!";
                    Yii::$app->getSession()->setFlash('success', $sms);
                    return $this->redirect(['view', 'id' => $modelProgrammeLoanItemCost->programme_id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('add_cost', [
                        'model' => $model,
                        'modelProgrammeLoanItemCost' => $modelProgrammeLoanItemCost,
                        'ProgrammeCost' => (empty($ProgrammeCost)) ? [new ProgrammeCost] : $ProgrammeCost,
                        //'ProgrammeCost' =>$ProgrammeCost,
                        'programme_id' => $id,
            ]);
        }
    }

    /*
      public function actionBulkUpload() {
      $model = new Programme;

      if (Yii::$app->request->post()) {

      }
      return $this->render('bulk_upload', [
      'model' => $model,
      ]);
      }
     * 
     */
    /*
      public function actionBulkUpload() {
      $model = new Programme;

      if (Yii::$app->request->post()) {

      }
      return $this->render('bulk_upload', [
      'model' => $model,
      ]);
      }
     * 
     */

    public function actionBulkUpload() {
        //$searchModelGepgBill = new ProgrammeSearch();
        //$modelGepgBill = new Programme();

        $searchModelProgramme = new ProgrammeSearch();
        $modelProgramme = new Programme();

        $loggedin = Yii::$app->user->identity->user_id;
        $dataProvider = $searchModelProgramme->search(Yii::$app->request->queryParams);
        $modelProgramme->scenario = 'programme_bulk_upload';
        if ($modelProgramme->load(Yii::$app->request->post())) {
            $date_time = date("Y_m_d_H_i_s");
            $inputFiles1 = UploadedFile::getInstance($modelProgramme, 'programe_file');
            $modelProgramme->programe_file = UploadedFile::getInstance($modelProgramme, 'programe_file');
            $modelProgramme->upload($date_time);
            $inputFiles = 'upload/' . $date_time . $inputFiles1;
            //$inputFiles =Yii::$app->params['excelUpload'].$date_time . $inputFiles1;

            try {
                $inputFileType = \PHPExcel_IOFactory::identify($inputFiles);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFiles);
            } catch (Exception $ex) {
                die('Error');
            }
            //exit;
            $learningInstitutionID = $modelProgramme->learning_institution_id;

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            if (strcmp($highestColumn, "E") == 0 && $highestRow >= 3) {
                //VALIDATING IF A FILE HAS NO RECORD TO BE DISCARDED...


                $row = 2;
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                //checking the template format
                $s_sno = $rowData[0][0];
                $PROGRAMME_NAME = $rowData[0][1];
                $PROGRAMME_CODE = $rowData[0][2];
                $PROGRAMME_GROUP_CODE = $rowData[0][3];
                $YEARS_OF_STUDY = $rowData[0][4];

                if (strcmp($s_sno, 'S/No') == 0 && strcmp($PROGRAMME_NAME, 'PROGRAMME_NAME') == 0 && strcmp($PROGRAMME_CODE, 'PROGRAMME_CODE') == 0 && strcmp($PROGRAMME_GROUP_CODE, 'PROGRAMME_GROUP_CODE') == 0 && strcmp($YEARS_OF_STUDY, 'YEARS_OF_STUDY') == 0) {
                    //end check template format
                    $sn = $s_sno;
                    if ($sn == '') {
                        unlink('upload/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['bulk-upload']);
                    } else {
                        $objPHPExcelOutput = new \PHPExcel();
                        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
                        $objPHPExcelOutput->setActiveSheetIndex(0);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'PROGRAMMES UPLOAD REPORT');
                        $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:G1', 'PROGRAMMES UPLOAD REPORT');

                        $rowCount = 3;
                        $s_no = 0;
                        $customTitle = ['SNo', 'PROGRAMME_NAME', 'PROGRAMME_CODE', 'PROGRAMME_GROUP_CODE', 'YEARS_OF_STUDY', 'UPLOAD STATUS', 'FAILED REASON'];
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);

                        for ($row = 3; $row <= $highestRow; ++$row) {
                            $s_no++;
                            $rowCount++;
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                            $modelProgramme = new Programme();
                            $modelProgramme->scenario = 'programme_bulk_upload3';
                            $modelProgramme->programme_name = Programme::formatRowData($rowData[0][1]);
                            $modelProgramme->programme_code = Programme::formatRowData($rowData[0][2]);
                            $modelProgramme->programmeGcode = Programme::formatRowData($rowData[0][3]);
                            $modelProgramme->years_of_study = Programme::formatRowData($rowData[0][4]);
                            $modelProgramme->learning_institution_id = $learningInstitutionID;
                            $modelProgramme->is_active = Programme::STATUS_PENDING;
                            $programmeGroupCode = \backend\modules\allocation\models\ProgrammeGroup::getProgrammGroupID($programmeGroupCode);
                            //$modelProgramme->learning_institution_id=1;
                            $modelProgramme->programme_group_id = $programmeGroupCode->programme_group_id;
                            //$modelGepgBill->date_created='';
                            $modelProgramme->validate();
                            $reason = '';
                            if ($modelProgramme->hasErrors()) {
                                $errors = $modelProgramme->errors;
                                foreach ($errors as $key => $value) {
                                    $reason = $reason . $value[0] . '  ';
                                }
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelProgramme->programme_name);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelProgramme->programme_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelProgramme->programmeGcode);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelProgramme->years_of_study);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, 'UPLOADED FAILED');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $reason);
                                unlink('upload/' . $date_time . $inputFiles1);
                            } else {
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelProgramme->programme_name);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelProgramme->programme_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelProgramme->programmeGcode);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelProgramme->years_of_study);
                                $modelProgramme->save();
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, 'UPLOADED SUCCESSFUL');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, 'N/A');
                            }
                        }
                        unlink('upload/' . $date_time . $inputFiles1);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
                        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="Programmes upload report.xls"');
                        header('Cache-Control: max-age=0');
                        $writer->save('php://output');
                        //$writer->save('upload'."/programmes_".$date_time.".xls");
                        $currentFileName = "programmes_" . $date_time . ".xls";

                        $sms = "Programmes file submitted, kindly check the upload results in excel file!";

                        Yii::$app->getSession()->setFlash('success', $sms);
                        // return $this->redirect(['bulk-upload']);
                    }
                } else {
                    unlink('upload/' . $date_time . $inputFiles1);
                    $sms = '<p>Operation failed,excel template used has invalid format, please download sample from system and populate data!</p>';
                    Yii::$app->getSession()->setFlash('error', $sms);
                    return $this->redirect(['bulk-upload']);
                }
            } else {
                unlink('upload/' . $date_time . $inputFiles1);
                $sms = '<p>Operation failed, file with no records is not allowed</p>';
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['bulk-upload']);
            }
        }
        return $this->render('bulk_upload', [
                    'model' => $modelProgramme,
        ]);
    }

    public function actionUploadError() {
        $model = new Programme();
        return $this->render('upload_error', [
                    'model' => $model,
        ]);
    }

    public function actionDownload($currentFileName) {
        $path = Yii::getAlias('@webroot') . '/upload';
        $file = $path . '/' . $currentFileName;
        if (file_exists($file)) {
            return Yii::$app->response->sendFile($file);
        } else {
            throw new \yii\web\NotFoundHttpException("{$file} is not found!");
        }
    }

    public function actionDownloadTemplate() {
        //$path=Yii::getAlias(Yii::$app->params['excelUpload']);
        $path = Yii::getAlias('@webroot') . '/upload';
        $file = $path . '/institution_programmes_template.xlsx';
        if (file_exists($file)) {
            return Yii::$app->response->sendFile($file);
        } else {
            throw new \yii\web\NotFoundHttpException("{$file} is not found!");
        }
    }

    /*
     * copy Pogramme cost from one year to another
     * 
     */

    public function actionCloneProgrammeCost($id) {
        $model = new Programme();
        $programme = $this->findModel($id);
        $model->scenario = 'clone_programme_cost';
        if ($model->load(Yii::$app->request->post('Programme')) && $programme->validate()) {
            foreach ($programme->loan_items as $loan_item) {
                $programme_cost = new ProgrammeCost();
                $programme_cost->loan_item_id = $loan_item;
                $programme_cost->academic_year_id = $programme->destination_academic_year;
                $programme_cost->programme_id = $programme->programme_id;
                $programme_cost->programme_type = $programme->programme_id; /////
                $programme_cost->rate_type = $loan_item->rate_type;
                $programme_cost->unit_amount = $loan_item->unit_amount;
                $programme_cost->duration = $loan_item->duration;
                $programme_cost->year_of_study = $programme->destination_study_year;
            }

            if ($save) {
                $sms = 'Close Operation Successful';
                Yii::$app->session->setFlash('success', $sms);
            } else {
                $sms = 'CLose Operation Failed';
                Yii::$app->session->setFlash('failure', $sms);
            }
        }
        return $this->render('cloneCost', [
                    'model' => $model, 'programme' => $programme
        ]);
    }

    public function actionCosts() {
        $model = new ProgrammeSearch();
        $model->scenario = 'search';
        $dataProvider = NULL;
        if (Yii::$app->request->get('ProgrammeSearch')) {
            $model->attributes = Yii::$app->request->get('ProgrammeSearch');
            $params = Yii::$app->request->get('ProgrammeSearch');
            if ($model->validate()) {
                $dataProvider = $model->searchProgammeCosts($params);
            }
        }
        return $this->render('programmeCosts', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionProgrammeCostSet() {
        $programme_data=Yii::$app->db->createCommand("Select * from programme pr  where  pr.programme_id NOT IN(select pc.programme_id from programme_cost pc)")->queryAll();
         // print_r($programme_data);
         //  exit();
             $i=5;
        foreach ($programme_data as $loan_item) {
            //find loan item
            $model_loan=ProgrammeCost::findAll(['programme_id'=>5]);
            //print_r($model_loan);
           // exit();
            foreach ( $model_loan as  $model_loans){
              $programme_cost = new ProgrammeCost();
                        $programme_cost->loan_item_id = $model_loans["loan_item_id"];
                        $programme_cost->academic_year_id =$model_loans["academic_year_id"];;
                        $programme_cost->programme_id = $loan_item["programme_id"];
                        $programme_cost->programme_type =$model_loans["programme_type"]; /////
                        $programme_cost->rate_type =$model_loans["rate_type"];
                        $programme_cost->unit_amount = $model_loans["unit_amount"];
                        $programme_cost->duration =$model_loans["duration"];
                        $programme_cost->year_of_study = $model_loans["year_of_study"];
                $programme_cost->save(false);
               
            }
            if($i==5){
                $i+=1;
            }
            else{
                $i-=1;
            }
            }
       
    
    }
    public function actionProgrammeCostSets() {
        $programme_data=Yii::$app->db->createCommand("Select * from learning_institution  li  where  institution_type<>'UNIVERSITY' AND li.learning_institution_id NOT IN(select pc.learning_institution_id from learning_institution_fee pc)")->queryAll();
        // print_r($programme_data);
        // exit();
        $amount=200000;
        $i=1;
        foreach ($programme_data as $model_loans) {
            //find loan item
            //$model_loan=ProgrammeCost::findAll(['programme_id'=>5]);
            //print_r($model_loan);
            // exit();
            //foreach ( $model_loan as  $model_loans){
                $programme_cost = new LearningInstitutionFee();
                $programme_cost->learning_institution_id = $model_loans["learning_institution_id"];
                $programme_cost->academic_year_id =1;
                $programme_cost->fee_amount =$amount*$i;
                $programme_cost->study_level =1; /////
                
                $programme_cost->save(false);
                
          //  }
            if($i>8){
                $i=1;
            }
             $i+=2;
        }
        
        
    }
}
