<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\ClusterDefinition;
use backend\modules\allocation\models\ClusterDefinitionSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Controller;

/**
 * ClusterDefinitionController implements the CRUD actions for ClusterDefinition model.
 */
class ClusterDefinitionController extends Controller {

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
     * Lists all ClusterDefinition models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ClusterDefinitionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClusterDefinition model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('profile', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ClusterDefinition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ClusterDefinition();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cluster_definition_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ClusterDefinition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cluster_definition_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ClusterDefinition model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClusterDefinition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClusterDefinition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ClusterDefinition::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //    public function actionLoanItems() {
    public function actionProgrammeGroup() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null && is_array($parents) && Count($parents) == 1) {
                $academic_year = trim(isset($parents[0]) ? $parents[0] : NULL);
                if ($academic_year) {
                    $items = \backend\modules\allocation\models\ProgrammeGroup::getProgrammeActiveGroupsNotInClusters($academic_year, 1);
                    foreach ($items as $item) {
                        $data = ['id' => $item['programme_group_id'], 'name' => $item['group_name']];
                        array_push($out, $data);
                    }
                    echo \yii\helpers\Json::encode(['output' => $out]);
                    return;
                }
            }
        }
        echo \yii\helpers\Json::encode(['output' => '']);
    }

    public function actionAddProgramme($id) {
        
    }

}
