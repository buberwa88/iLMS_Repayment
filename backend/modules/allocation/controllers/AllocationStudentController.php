<?php
namespace backend\modules\allocation\controllers;
use Yii;
use common\components\Controller;
use yii\filters\VerbFilter;
use backend\modules\application\models\ApplicationSearch;
use backend\modules\allocation\models\Application;
class AllocationStudentController extends Controller
{
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
    public function actionIndex()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->searchcompliance(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id) {
        
        return $this->render('profile', [
            'model' => $this->findModel($id),
        ]);
    }
    protected function findModel($id) {
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
