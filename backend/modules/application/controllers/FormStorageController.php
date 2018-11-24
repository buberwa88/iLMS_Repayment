<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/11/18
 * Time: 7:24 AM
 */

namespace backend\modules\application\controllers;
use backend\modules\allocation\models\Application;
use Yii;
use backend\modules\application\models\Applicant;
use backend\modules\application\models\ApplicantSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use common\components\Controller;
use common\models\FormStorage;
use yii\web\Controller;

class FormStorageController extends Controller
{
    public function behaviors()
    {
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

    public static function NumberFiller($number,$size,$repeater)
    {
        $output = '';
        //$repeater = '0';

        if ($size>strlen($number)){
            $limit = $size - strlen($number);
            for ($i=1; $i<=$limit; $i++){
                $output.=$repeater;
            }
        }

        return $output.$number;
    }

    public static function NumberGenerator()
    {
        $format = date('Y');
        $counter = 0;
        $SQL = "SELECT COUNT(id) AS 'counter' FROM form_storage WHERE YEAR(date_created) = YEAR(CURDATE())";
        $model = \Yii::$app->db->createCommand($SQL)->queryAll();
        if (sizeof($model)!==0){
            $counter=$model[0]['counter'];
        }
        //$counter=;
        $counter++;

        return $format.'-'.self::NumberFiller($counter,6,'0');
    }


    public function actionIndex(){
        return $this->render('index');
    }



    public function actionRetrieving(){

        if (Yii::$app->request->isAjax) { //Making sure its an ajax request
                   ini_set('max_execution_time','-1');
                   ini_set('memory_limit', '-1');
            $output = array();
            $WHERE = "";
            if (isset($_POST['indexNumber'])&&!empty($_POST['indexNumber'])){
                $index = $_POST['indexNumber'];
                $WHERE.= "
                (applicant.f4indexno = '$index' OR applicant.f6indexno = '$index')";
            }

            if (isset($_POST['formNumber'])&&!empty($_POST['formNumber'])){
                $formNumber = $_POST['formNumber'];
                if ($WHERE!=""){
                    $WHERE.=" OR ";
                }
                $WHERE.= "
                application.application_form_number = '$formNumber'           
                ";
            }

            if ($WHERE!=""){

                $output=self::SearchQuery($WHERE,20);
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $output;
        }else {
            return $this->render('retrieve');
        }
    }
    public function actionMobile(){

        if (Yii::$app->request->isAjax) { //Making sure its an ajax request
            ini_set('max_execution_time','-1');
            ini_set('memory_limit', '-1');
            $output = array();
            $WHERE = " (application.form_storage_id IS NOT NULL) ";
            if (isset($_POST['indexNumber'])&&!empty($_POST['indexNumber'])){
                $index = $_POST['indexNumber'];
                $WHERE.= " AND (applicant.f4indexno = '$index' OR applicant.f6indexno = '$index')";
            }

            if (isset($_POST['formNumber'])&&!empty($_POST['formNumber'])){
                $formNumber = $_POST['formNumber'];
                if ($WHERE==" (application.form_storage_id NO NULL) "){ $WHERE.=" OR "; }else{ $WHERE.=" AND ";}
                $WHERE.= "application.application_form_number = '$formNumber'";
            }

            if (isset($_POST['folderNumber'])&&!empty($_POST['folderNumber'])){
                $folderNumber = $_POST['folderNumber'];

                $WHERE.= " AND(form_storage.folder_number = '$folderNumber')";
            }

            if ($WHERE!=""){ $output=self::SearchQuery($WHERE,1);  }

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $output;
        }else {
            return $this->render('mobile');
        }
    }

    public static function SearchQuery($conditions,$limit){
        $output = array();
        $SQL = "
            SELECT 
                application.application_form_number AS 'form_number',
                applicant.f4indexno AS 'form_four_index_number',
                applicant.f6indexno AS 'form_six_index_number',
                CONCAT(user.firstname,' ',user.middlename,' ',user.surname) AS 'applicant_name',
                application.storage_sequence AS 'storage_sequence',
                form_storage.folder_number AS 'folder_number',
                (CASE WHEN application.form_storage_id IS NOT NULL THEN 'FILED' ELSE (CASE WHEN application.form_storage_id IS NULL THEN 'NOT FILED' ELSE 'NOT SET' END) END) AS 'remarks',
                form_storage.folder_limit AS 'folder_limit'
            FROM application
            LEFT JOIN applicant ON application.applicant_id = applicant.applicant_id
            LEFT JOIN user ON user.user_id = applicant.user_id
            LEFT JOIN form_storage ON application.form_storage_id = form_storage.id
            WHERE $conditions
            ORDER BY form_storage.folder_number ASC, application.storage_sequence ASC
            LIMIT $limit;
        ";
        $output=Yii::$app->db->createCommand($SQL)->queryAll();
        return $output;
    }

    public function actionFolder(){

        $output=array('output'=>'','folderID'=>'','folderLimit'=>0, 'folderContent'=>0);
        if (Yii::$app->request->isAjax){ //Making sure its an ajax request
            if (isset($_POST['limit'])&&!empty($_POST['limit']))
            {
                $limit = $_POST['limit'];
                $model = new FormStorage();
                $model->folder_number = self::NumberGenerator();
                $model->folder_limit = $limit;
                $model->created_by = Yii::$app->user->id;
                $model->date_created = date('Y-m-d H:i:s');
                $model->last_retrieval = date('Y-m-d H:i:s');
                if ($model->save()){
                    $output=array('output'=>$model->folder_number,'folderID'=>$model->id,'folderLimit'=>$model->folder_limit, 'folderContent'=>0);
                }else{
                    $output=array('output'=>json_encode($model->getErrors()));
                }
            }


            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $output;
        }else{

            return $output;
        }


    }

    public function actionSearcher()
    {
        $output=array('output'=>'','folderID'=>'','folderLimit'=>0, 'folderContent'=>0);
        if (Yii::$app->request->isAjax) { //Making sure its an ajax request

            if (isset($_POST['keyWord'])){
                $keyWord = $_POST['keyWord'];

               $output = self::SearchFolder($keyWord);

            }else{
                $output=array('output'=>'','folderID'=>'','folderLimit'=>0, 'folderContent'=>0);
            }


            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $output;
        }else{

            return $output;
        }


    }

    public static function SearchFolder($keyWord)
    {
        $output=array('output'=>'','folderID'=>'','folderLimit'=>0, 'folderContent'=>0);
        $SQL = "
                SELECT * 
                FROM form_storage 
                WHERE folder_number ='$keyWord'";
        $model = Yii::$app->db->createCommand($SQL)->queryAll();
        if (sizeof($model)!=0){
            foreach ($model as $index=>$dataArray){
                $storageID = $dataArray['id'];
                $SQLlogged = "SELECT applicant_id,application_form_number,application_number FROM application WHERE form_storage_id='$storageID' ORDER BY storage_sequence ASC";
                $modelLogged=Yii::$app->db->createCommand($SQLlogged)->queryAll();
                $Logged =  sizeof($modelLogged);
                $output=array('output'=>$dataArray['folder_number'],'folderID'=>$dataArray['id'],'folderLimit'=>$dataArray['folder_limit'], 'folderContent'=>$Logged, 'formList'=>$modelLogged);
            }
        }else{
            $output=array('output'=>'','folderID'=>'','folderLimit'=>0, 'folderContent'=>0);
        }

        return $output;
    }
    public function actionSearcher2()
    {
        $output=array();
        if (Yii::$app->request->isAjax) { //Making sure its an ajax request

               $WHERE ="WHERE 1=1 ";

                if (isset($_POST['keyWord']) && !empty($_POST['keyWord'])){$keyWord = $_POST['keyWord'];  $WHERE.=" AND (folder_number LIKE '%$keyWord%')";}
                if (isset($_POST['year']) && !empty($_POST['year'])){$year = $_POST['year']; $WHERE.=" AND YEAR(date_created) = '$year'";}

                $SQL = "SELECT * FROM form_storage $WHERE";
                $model = Yii::$app->db->createCommand($SQL)->queryAll();
                if (sizeof($model)!=0){
                    foreach ($model as $index=>$dataArray){
                        $storageID = $dataArray['id'];
                        $SQLlogged = "SELECT applicant_id,application_form_number,application_number FROM application WHERE form_storage_id='$storageID' ORDER BY storage_sequence ASC";
                        $modelLogged=Yii::$app->db->createCommand($SQLlogged)->queryAll();
                        $Logged =  sizeof($modelLogged);
                        $output[]=array('output'=>$dataArray['folder_number'],'folderID'=>$dataArray['id'],'folderLimit'=>$dataArray['folder_limit'], 'folderContent'=>$Logged, 'formList'=>$modelLogged);
                    }
                }

                     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $output;
        }else{

            return $output;
        }


    }

    public function actionStore()
    {

        if (Yii::$app->request->isAjax) { //Making sure its an ajax request
            $output=array('output'=>'');
            if (isset($_POST['keyWord'])&&isset($_POST['folderID'])){
                $keyWord = $_POST['keyWord'];
                $folderID = $_POST['folderID'];
                $sequence = $_POST['sequence'];
                $SQL = "SELECT application_id,applicant_id,application_form_number,application_number FROM application WHERE form_storage_id  IS NULL AND application_form_number='$keyWord'";
                $model = Yii::$app->db->createCommand($SQL)->queryAll();
                if (sizeof($model)!=0){
                    foreach ($model as $index=>$dataArray){
                        $ID = $dataArray['application_id'];

                    }
                    $updateSQL="UPDATE application SET form_storage_id = '$folderID', storage_sequence='$sequence' WHERE application_id='$ID' AND  application_form_number = '$keyWord' AND form_storage_id IS NULL";

                    $updates = Yii::$app->db->createCommand($updateSQL)->execute();

                    $output=array('output'=>$updates);

                }

            }else{
                $output=array('output'=>'');
            }


            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $output;
        }else{

            return $this->render('store');
        }

    }



    public function actionRemoving(){

    }

    public function actionTransfer(){
        $output= array('source'=>'','destination'=>'');

        if (Yii::$app->request->isAjax) { //Making sure its an ajax request


            if (isset($_POST['transferList'])&&!empty($_POST['transferList'])){
                $transferList=$_POST['transferList'];
                $destinationFolder=$_POST['destination'];

                self::FileMovement($transferList,$destinationFolder);
                $output['source'] = self::SearchFolder($_POST['source']);
                $output['destination'] = self::SearchFolder($_POST['destination']);
            }else{
                switch ($_POST['target']){
                    case 'source':
                        $output['source'] = self::SearchFolder($_POST['keyWord']);
                        $output['destination'] = '';
                        break;

                    case 'destination':
                        $output['source'] ='';
                        $output['destination'] = self::SearchFolder($_POST['keyWord']);
                        break;


                }
            }






                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $output;
            }else{

            return $this->render('transfer');
        }

    }

    public static function FileMovement($transferList,$destinationFolder)
    {
            $SQL = "SELECT id FROM form_storage WHERE folder_number = '$destinationFolder' LIMIT 1";
            $folderModel = Yii::$app->db->createCommand($SQL)->queryAll();
            if (sizeof($folderModel)!=0){
                $folderID = $folderModel[0]['id'];
                $SQLupdate = "";
                $counter = 0;
                $SQLcheck = "SELECT MAX(storage_sequence) AS 'max_sequence' FROM application WHERE form_storage_id='$folderID'";
                $checkModel = Yii::$app->db->createCommand($SQLcheck)->queryAll();
                if (sizeof($checkModel)!=0){
                    $counter = $checkModel[0]['max_sequence'];
                }
                foreach ($transferList as $index=>$formNo){
                    $counter++;
                    $SQLupdate.= "UPDATE application SET form_storage_id = '$folderID' , storage_sequence = '$counter' WHERE application_form_number = '$formNo';";
                }
                if ($SQLupdate!=''){
                    Yii::$app->db->createCommand($SQLupdate)->execute();
                }
            }
    }
    public function actionFolderOperation(){

        $operation = $_POST['operation'];
        $folderID = $_POST['folderID'];

        switch ($operation){

            case 'open':

                break;

            case 'close':

                break;

            case 'archive':

                break;
        }
    }
}