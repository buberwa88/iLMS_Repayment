<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Complete Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
    <?php  //echo $this->render('_search', ['model' => $searchModel,'action' => 'complete-applications']); ?>
     <?php  echo $this->render('_search_application_verification', ['model' => $searchModel,'action'=>'complete-applications']); ?>       
 
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
                    ],
              [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
                    ],
                    [
                     'attribute' => 'middleName',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
                    ],
                    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
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

        ],
    ]); ?>
</div>
</div>
</div>
