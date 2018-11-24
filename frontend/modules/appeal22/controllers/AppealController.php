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
        $this->layout="main_private";
        
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

        return $this->render('index', [
            'dataProvider' => $dataProvider,
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

    /**
     * Creates a new Appeal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $appeal = $this->findModel($id);

        $appelCategory = AppealCategory::find()->all();
        $model = new AppealCategory();
        $models = [new AppealCategory()];
        $appealQuestions = AppealQuestion::find()->all();

        return $this->render('create', ['model'=>$model, 'models'=>$models, 'appeal'=>$appeal, 'appealQuestions'=>$appealQuestions, 'appealCategories'=>$appelCategory]);
    }

    /**
     * Creates a new Appeal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionStore($id)
    {
    
        $data = Yii::$app->request->post();

        $appelCategory = $data['AppealCategory']['appeal_category_id'];

        $appeal = Appeal::findOne(['appeal_id'=> $id]);

        $appeal->appeal_category_id = $appelCategory;

        $appealQns = $data['qn'];

        $appealAttachments = [];

        foreach($appealQns as $k=>$qn){
           
            if($qn == "1"){

                $appAtt = new AppealAttachment();
                $att = UploadedFile::getInstanceByName('answ['.$k.']');
                $fName = Yii::$app->security->generateRandomString().'.'.$att->extension;

                $path = $att->saveAs('/home/stan/uploads/'.$fName);

                $appAtt->appeal_id = $id;
                $appAtt->appeal_question_id = $k;
                $appAtt->attachment_path = "ks";//$fName;

                $appAtt->save(false);

                
            }

        }
        
        $appeal->save();

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Updates an existing Appeal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->appeal_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
