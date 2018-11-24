<?php

namespace backend\modules\appeal\controllers;

use Yii;
use backend\modules\appeal\models\Appeal;
use backend\modules\appeal\models\AppealCategory;
use backend\modules\appeal\models\AppealQuestion;
use backend\modules\appeal\models\AppealAttachment;

use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppealController implements the CRUD actions for Appeal model.
 */
class AppealController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $this->layout="main_private_main";
        
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
     * Lists all Appeal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Appeal::find(),
        ]);

        $title = 'All Appeals';

        return $this->render('index', [
            'dataProvider' => $dataProvider, 'title'=>$title
        ]);
    }

    /**
     * Lists all Appeal models.
     * @return mixed
     */
    public function actionVerifiedAppeal()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Appeal::find()->where('verification_status', '=', '1'),
        ]);

        $title = 'Verified Appeal';

        return $this->render('index', [
            'dataProvider' => $dataProvider, 'title'=>$title
        ]);
    }

    /**
     * Lists all Appeal models.
     * @return mixed
     */
    public function actionUnVerifiedAppeal()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Appeal::find()->where(['verification_status'=>'0', 'submitted'=>'1']),
        ]);

        $title = "Unverified Appeal";

        return $this->render('index', [
            'dataProvider' => $dataProvider, 'title'=>$title
        ]);
    }

    /**
     * Displays a single Appeal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $appeal = $this->findModel($id);

        $appealAttachments = new ActiveDataProvider([
            'query' => AppealAttachment::find()->where(['appeal_id'=> $id]),
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id), 'appealAttachments'=>$appealAttachments
        ]);
    }


    public function actionDownload($id){
        
        $att = AppealAttachment::findOne(['appeal_attachment_id'=>$id]);

        $file = "/home/stan/uploads/".$att->attachment_path;

        if (file_exists($file)) {
            Yii::$app->response->xSendFile($file);
        }

    }

    /**
     * Deletes an existing Appeal model.
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
     * Finds the Appeal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Appeal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Appeal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionAttachmentStatus($id, $status){

        $attachment = AppealAttachment::findOne(['appeal_attachment_id'=>$id]);

        if($attachment != null){
            $attachment->verification_status = $status;
            $attachment->save();
        }

        return $this->redirect(['view', 'id' => $attachment->appeal_id]);
    }
}
