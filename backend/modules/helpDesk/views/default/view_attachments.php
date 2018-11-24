<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */

//$this->title ="Attachment List";
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['view-application']];
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => Yii::$app->request->referrer];
//$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 150px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
   <div class="panel-body">
       <div class="row" style="margin: 1%;">        
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">                   
              </div>   
                <?php 
                $getAcademicYearHelpDesk=\backend\modules\application\models\Application::find()
                        ->joinWith('academicYear')
                        ->where("application.application_id = {$application_id}")->one();
                 ?>
               <p>
                   <table class="table table-striped table-bordered detail-view" id="w1">
                <tbody>
                    <tr>
                        <td><strong>Application Year</strong></td>
                        <td><strong>Application Status</strong></td>
                        <td><strong>Application Form Number</strong></td>
                        <td><strong>Overall Verification Status</strong></td>                        
                    </tr>
                    <tr><td><?php echo $getAcademicYearHelpDesk->academicYear->academic_year; ?></td><td><?php if($getAcademicYearHelpDesk->loan_application_form_status == 3){
                        echo Html::label("Submitted", NULL, ['class'=>'label label-success']);
                    }else{
                        echo Html::label("Not Submitted", NULL, ['class'=>'label label-danger']);
                    } ?></td><td><?php echo $getAcademicYearHelpDesk->application_form_number; ?></td><td><?php 
                    if($getAcademicYearHelpDesk->verification_status == 0){
                            echo Html::label("UNVERIFIED", NULL, ['class'=>'label label-default']);
                            } else if($getAcademicYearHelpDesk->verification_status == 1) {
                            echo Html::label("COMPLETE", NULL, ['class'=>'label label-success']);
                            }
                              else if($getAcademicYearHelpDesk->verification_status == 2) {
                            echo Html::label("INVALID", NULL, ['class'=>'label label-danger']);
                            }
                               else if($getAcademicYearHelpDesk->verification_status == 3) {
                            echo Html::label("INVALID", NULL, ['class'=>'label label-warning']);
                                    }else if($getAcademicYearHelpDesk->verification_status == 4) {
                            echo Html::label("INCOMPLETE", NULL, ['class'=>'label label-danger']);
                                    }else if($getAcademicYearHelpDesk->verification_status == 5) {
                            echo Html::label("PENDING", NULL, ['class'=>'label label-warning']);
                                    } 
                    ?></td></tr>
                </tbody>
            </table>
              </p>
          </div>
        </div>        
    </div>
      <div class="col-xs-12">
          <div class="box box-primary">
          <div class="box-header">
                    <h3 class="box-title" style="text-align:centre;"><strong>ATTACHMENTS</strong></h3>
                </div>
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => '',
        'columns' => [
             ['class' => 'yii\grid\SerialColumn'],            
              [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model){
                  return $this->render('attachment_view',['model'=>$model,'fullname' => $fullname,'application_id'=>$application_id1,'released'=>$released]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
            ],
             [
                        'label'=>"Attachment",
                        'value' => function ($model) {
                            return $model->attachmentDefinition->attachment_desc;							
                        },       
             ], 
			 
             [
                    'label' => 'Verification Status',
                    'value' => function ($model){
						
                       if($model->verification_status == 0){
                            return Html::label("UNVERIFIED", NULL, ['class'=>'label label-default']);
                            } else if($model->verification_status == 1) {
                            return Html::label("VALID", NULL, ['class'=>'label label-success']);
                            }
                              else if($model->verification_status == 2) {
                            return Html::label("INVALID", NULL, ['class'=>'label label-danger']);
                            }
                               else if($model->verification_status == 3) {
                                        return Html::label("INVALID", NULL, ['class'=>'label label-warning']);
                                    }else if($model->verification_status == 4) {
                                        return Html::label("INCOMPLETE", NULL, ['class'=>'label label-danger']);
                                    }else if($model->verification_status==5) {
                                        return Html::label("Pending", NULL, ['class'=>'label label-warning']);
                                    }
                        },
                                'format' => 'raw'
                    ],                                 
                         
                         [
                'label' => 'Verification Status Reason',             
                    'value' => function ($model){
                            if($model->attachmentComment->comment_group==''){
                       return '';         
                            }else{
                       return $model->attachmentComment->comment_group;
                            }
                        },                         
                    ],
                         
           ],
      ]); ?>
</div> 
      </div>
</div>
