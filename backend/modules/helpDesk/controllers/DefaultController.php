<?php

namespace backend\modules\helpDesk\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\application\models\ApplicationSearch;

/**
 * Default controller for the `appleal` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = "main_private";
    /*
    public function actionIndex()
    {
        return $this->render('index');
    }
     * 
     */
    public function actionIndex() {
        $searchModel = new ApplicationSearch();
		
        $dataProvider=$searchModel->searchHelpDeskInitiate(Yii::$app->request->queryParams);
         if ($searchModel->assignee_asi=='CheckSearch') {
        $dataProvider = $searchModel->searchHelpDesk(Yii::$app->request->queryParams);
         }
        
		//$results=$searchModel->searchHelpDesk2(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,                    
        ]);
    }
	public function actionView($id) {
		$searchModel = new ApplicationSearch();
                $searchModelApplicantAssociate=new \frontend\modules\application\models\ApplicantAssociateSearch();
                $searchModelApplicantAttachment=new \frontend\modules\application\models\ApplicantAttachmentSearch();
                $searchModeleducation=new \frontend\modules\application\models\EducationSearch();
                $searchModelAllocatedLoan = new \backend\modules\allocation\models\AllocationSearch();
        $dataProvider = $searchModel->searchHelpDesk(Yii::$app->request->queryParams);
	    $model =\backend\modules\application\models\Application::find()
                    ->where(['application.application_id'=>$id])
                    ->JoinWith('applicant')
                    ->joinwith(["applicant","applicant.user"])
                    ->one();
    $dataProviderApplicantAssociate = $searchModelApplicantAssociate->searchHelpDesk(Yii::$app->request->queryParams,$id);
    $dataProviderApplicantAttachment = $searchModelApplicantAttachment->searchAttachments(Yii::$app->request->queryParams,$id);
    $dataProviderEducation = $searchModeleducation->searchHelpDesk(Yii::$app->request->queryParams,$id);
    $dataProviderAllocatedLoan = $searchModelAllocatedLoan->searchAllocatedLoanHelpDesk(Yii::$app->request->queryParams,$id);
        return $this->render('view', [
                    'model' => $model,
		    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'application_id'=>$id,
                    'searchModelApplicantAssociate'=>$searchModelApplicantAssociate,
                    'dataProviderApplicantAssociate'=>$dataProviderApplicantAssociate,
                    'dataProviderApplicantAttachment'=>$dataProviderApplicantAttachment,
                    'searchModelApplicantAttachment'=>$searchModelApplicantAttachment,
                    'dataProviderEducation'=>$dataProviderEducation,
                    'searchModeleducation'=>$searchModeleducation,
                    'searchModelAllocatedLoan'=>$searchModelAllocatedLoan,
                    'dataProviderAllocatedLoan'=>$dataProviderAllocatedLoan,
                    
        ]);
          
   }
}
