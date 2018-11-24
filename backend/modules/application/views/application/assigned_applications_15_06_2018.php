<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Assigned Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
<div class="panel panel-info">
    <div class="panel-heading">
         
     <?= Html::encode($this->title) ?>
          
    </div>
    <div class="panel-body">
    <?php  //echo $this->render('_search_application_verification', ['model' => $searchModel,'action'=>'unverified-applications']); ?>
        <p >
        <?=Html::beginForm(['application/reverseapplication-assigned'],'post');?>        
                
    </p>
 
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                     'attribute' => 'middlename',
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
                     'attribute' => 'assignee',
                     'label'=>'Assignee',
                        'value' => function ($model) {
                                   
                                     return $model->assignee0->firstname." ".$model->assignee0->middlename." ".$model->assignee0->surname;
                                    
                        },                        
                    ],
                                ['class' => 'yii\grid\CheckboxColumn'],
        ],
    ]); ?>
    <div class="text-right">
    <?=Html::submitButton('Reverse', ['class' => 'btn btn-warning',]);?>
        </div>
    <?= Html::endForm();?>
</div>
</div>
</div>
