<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Incomplete Refund Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
<div class="panel panel-info">
    <div class="panel-heading">
         
     <?= Html::encode($this->title) ?>
          
    </div>
    <div class="panel-body">
        <?php
        echo $this->render('_verification_attempted');
        ?>
    <?php  echo $this->render('_search_application_verification', ['model' => $searchModel,'action'=>'incompleteref']); ?>
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

              [
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->firstname, ['/repayment/refund-application-operation/view-refund','id'=>$model->refund_application_id]);
                        },
                    ],
                    [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->middlename, ['/repayment/refund-application-operation/view-refund','id'=>$model->refund_application_id]);
                        },
                    ],
                    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->surname, ['/repayment/refund-application-operation/view-refund','id'=>$model->refund_application_id]);
                        },
                    ],
            [
                'attribute' => 'refund_type_id',
                'label'=>'Category',
                'width' => '140px',
                'value' => function ($model) {
                    if($model->refund_type_id ==1){
                        //return "Non Beneficiary";
                        return Html::a("Non Beneficiary", ['/repayment/refund-application-operation/view-refund','id'=>$model->refund_application_id]);
                    } else if($model->refund_type_id==2) {
                        //return "Over Deducted";
                        return Html::a("Over Deducted", ['/repayment/refund-application-operation/view-refund','id'=>$model->refund_application_id]);
                    }
                    else if($model->refund_type_id==3) {
                        //return "Deceased";
                        return Html::a("Deceased", ['/repayment/refund-application-operation/view-refund','id'=>$model->refund_application_id]);
                    }
                },
                'format' => 'raw'
            ],
                   [
                     'attribute' => 'current_status',
                       'label'=>'Status',
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->current_status ==0){
                                     return Html::label("Unvarified", NULL, ['class'=>'label label-default']);
                                    } else if($model->current_status==1) {
                                        return Html::label("Complete", NULL, ['class'=>'label label-success']);
                                    }
                                   else if($model->current_status==2) {
                                        return Html::label("Incomplete", NULL, ['class'=>'label label-danger']);
                                    }
                                  else if($model->current_status==3) {
                                        return Html::label("Waiting", NULL, ['class'=>'label label-warning']);
                                    }else if($model->current_status==4) {
                                        return Html::label("Invalid", NULL, ['class'=>'label label-danger']);
                                    }else if($model->current_status==5) {
                                        return Html::label("Pending", NULL, ['class'=>'label label-warning']);
                                    }
                        },
                        'format' => 'raw'
                    ],              
            
             [
               'label'=>'',
               'value'=>function($model){
                  return Html::a("Application Details", ['/repayment/refund-application-operation/view-refund','id'=>$model->refund_application_id,'action' => 'view'], ['class'=>'label label-success']);
               },
               'format'=>'raw',
             ],
             [
               'label'=>'',
               'value'=>function($model){
                  return Html::a("Verify", ['/repayment/refund-application-operation/view-refund','id'=>$model->refund_application_id], ['class'=>'label label-primary']);
               },
               'format'=>'raw',
             ],
        ],
    ]); ?>
</div>
</div>
</div>
