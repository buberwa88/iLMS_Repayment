<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Incomplete Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 
   <?php  //echo $this->render('_search', ['model' => $searchModel,'action' => 'incomplete-applications']); ?>
            <?php  echo $this->render('_search_application_verification', ['model' => $searchModel,'action'=>'incompleted-applications']); ?>
 
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        'width' => '200px',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->applicant->f4indexno, ['/application/application/view','id'=>$model->application_id]);
                        },
                    ],
              [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->applicant->user->firstname, ['/application/application/view','id'=>$model->application_id]);
                        },
                    ],
                    [
                     'attribute' => 'middleName',
                        'label'=>"Middle Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->applicant->user->middlename, ['/application/application/view','id'=>$model->application_id]);
                        },
                    ],
                    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->applicant->user->surname, ['/application/application/view','id'=>$model->application_id]);
                        },
                    ],

                     [
                     'attribute' => 'sex',
                        'label'=>"Sex",
                        'value' => function ($model) {
                            return $model->applicant->sex;
                        },
                    ],

                    [
                     'attribute' => 'applicant_category_id',
                        'label'=>"Category",
                        'value' => function ($model) {
                            return $model->applicantCategory->applicant_category;
                        },
                    ],

/*
[
                     'attribute' => 'systemStatus',
		     'label'=>"System Status",
                        'width' => '140px',
                        'value' => function ($model) { 
                            $systemStatus_custom_criteria=backend\modules\application\models\VerificationFramework::getGeneralSystemStatus($model->application_id,$model->applicant_id,$model->verification_framework_id,$model->applicant_category_id);
                            $systemStatus_mandatory_attachments=backend\modules\application\models\VerificationFramework::getGeneralSystemStatusMandatoryAttachments($model->application_id,$model->verification_framework_id,$model->applicant_category_id);
                                   if($systemStatus_custom_criteria==0 || $systemStatus_mandatory_attachments ==0){
                                     return Html::label("Failed", NULL, ['class'=>'label label-danger']);
                                    } else if($systemStatus_custom_criteria==1 && $systemStatus_mandatory_attachments ==1) {
                                        return Html::label("OK", NULL, ['class'=>'label label-success']);
                                    }
                        },
                        'format' => 'raw'
                    ],
*/

                   [
                     'attribute' => 'verification_status',
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->verification_status ==0){
                                     return Html::label("Unvarified", NULL, ['class'=>'label label-default']);
                                    } else if($model->verification_status==1) {
                                        return Html::label("Complete", NULL, ['class'=>'label label-success']);
                                    }
                                   else if($model->verification_status==2) {
                                        return Html::label("Incomplete", NULL, ['class'=>'label label-danger']);
                                    }
                                  else if($model->verification_status==3) {
                                        return Html::label("Waiting", NULL, ['class'=>'label label-warning']);
                                    }else if($model->verification_status==4) {
                                        return Html::label("Invalid", NULL, ['class'=>'label label-danger']);
                                    }else if($model->verification_status==5) {
                                        return Html::label("Pending", NULL, ['class'=>'label label-warning']);
                                    }
                        },
                        'format' => 'raw'
                    ],              
            
             [
               'label'=>'',
               'value'=>function($model){
                  return Html::a("Application Details", ['/application/application/view','id'=>$model->application_id,'action' => 'view'], ['class'=>'label label-success']);
               },
               'format'=>'raw',
             ],
             [
               'label'=>'',
               'value'=>function($model){
                  return Html::a("Verify", ['/application/application/view','id'=>$model->application_id], ['class'=>'label label-primary']);
               },
               'format'=>'raw',
             ],
        ],
    ]); ?>
</div>
</div>
</div>
