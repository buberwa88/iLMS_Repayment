<?php

namespace backend\modules\application\controllers;

use Yii;
use backend\modules\application\models\VerificationComment;
use backend\modules\application\models\VerificationCommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VerificationCommentController implements the CRUD actions for VerificationComment model.
 */
class VerificationCommentController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all VerificationComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VerificationCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VerificationComment model.
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
     * Creates a new VerificationComment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
/*
    public function actionCreate()
    {
        $model = new VerificationComment();
        $model->created_by=Yii::$app->user->identity->user_id;
        $model->created_at=date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $sms="<p>Information successful added</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
*/

public function actionCreate()
    {
        $model = new VerificationComment();
        $created_by=Yii::$app->user->identity->user_id;
        $created_at=date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())) {
            $attachment_definition_id=$model->attachment_definition_id;
            $array=$model->verification_comment_group_id;
foreach ($array as $value) {
$empModel = new VerificationComment();
$empModel->attachment_definition_id =$attachment_definition_id;
$empModel->verification_comment_group_id = $value;
$empModel->created_by = $created_by;
$empModel->created_at = $created_at;
$resultsCount=VerificationComment::find()->where(['attachment_definition_id'=>$attachment_definition_id,'verification_comment_group_id'=>$value,'is_active'=>1])->count();
if($resultsCount==0){
$empModel->save(false);
}
} 
            
            $sms="<p>Information successful added</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VerificationComment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario='update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $sms="<p>Information successful updated</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VerificationComment model.
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
     * Finds the VerificationComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VerificationComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VerificationComment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
