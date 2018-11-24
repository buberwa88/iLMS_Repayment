<?php

namespace backend\modules\disbursement\controllers;

use Yii;
use backend\modules\disbursement\models\InstalmentDefinition;
use backend\modules\disbursement\models\InstalmentDefinitionSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;
/**
 * InstalmentDefinitionController implements the CRUD actions for InstalmentDefinition model.
 */
class InstalmentDefinitionController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = "main_private";
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
     * Lists all InstalmentDefinition models.
     * @return mixed
     */
    public function actionIndex()
    {
      
        $searchModel = new InstalmentDefinitionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InstalmentDefinition model.
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
     * Creates a new InstalmentDefinition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model = new InstalmentDefinition();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
         //   echo implode(",",array_keys(Yii::$app->request->post('InstalmentDefinition')));
            //create logo $model->instalment_definition_id
            // $logsModel->CreateLog($primaryKey,$old_data,$new_data,$table_name,$action);
              $new_data=Yii::$app->request->post('InstalmentDefinition');
              $logsModel = new \common\models\base\Logs();
              $logsModel->CreateLog($model->instalment_definition_id,$old_data=NULL,$new_data,"instalment_definition","create");
        
             Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfuly Created!'
                        );
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InstalmentDefinition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
  
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
         //   print_r($model);
            $model["_oldAttributes:yii\db\BaseActiveRecord:private"];
                 exit();
                $new_data=Yii::$app->request->post('InstalmentDefinition');
              $logsModel = new \common\models\base\Logs();
              $logsModel->CreateLog($model->instalment_definition_id,$old_data=NULL,$new_data,"instalment_definition","create");
        
                        Yii::$app->getSession()->setFlash(
                                'success', 'Data Successfuly Updated!'
                        );
            return $this->redirect(['update', 'id' => $model->instalment_definition_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InstalmentDefinition model.
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
     * Finds the InstalmentDefinition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstalmentDefinition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InstalmentDefinition::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
