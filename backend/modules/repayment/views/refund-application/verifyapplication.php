<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Refund Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
<div class="panel panel-info">
    <div class="panel-heading">
         
     <?= Html::encode($this->title) ?>
          
    </div>
    <div class="panel-body">
        <?php
        //echo $this->render('_verification_attempted');
        ?>
    <?php  echo $this->render('_search_application_verification', ['model' => $searchModel,'action'=>'verifyapplication']); ?>
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
                            return Html::a($model->firstname, ['/repayment/refund-application-operation/view-refundlevel','id'=>$model->refund_application_id]);
                        },
                    ],
                    [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->middlename, ['/repayment/refund-application-operation/view-refundlevel','id'=>$model->refund_application_id]);
                        },
                    ],
                    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->surname, ['/repayment/refund-application-operation/view-refundlevel','id'=>$model->refund_application_id]);
                        },
                    ],
            [
                'attribute' => 'refund_type_id',
                'label'=>'Category',
                'width' => '140px',
                'value' => function ($model) {
                    if($model->refund_type_id ==1){
                        //return "Non Beneficiary";
                        return Html::a("Non Beneficiary", ['/repayment/refund-application-operation/view-refundlevel','id'=>$model->refund_application_id]);
                    } else if($model->refund_type_id==2) {
                        //return "Over Deducted";
                        return Html::a("Over Deducted", ['/repayment/refund-application-operation/view-refundlevel','id'=>$model->refund_application_id]);
                    }
                    else if($model->refund_type_id==3) {
                        //return "Deceased";
                        return Html::a("Deceased", ['/repayment/refund-application-operation/view-refundlevel','id'=>$model->refund_application_id]);
                    }
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'current_level',
                'label'=>'Current Level',
                'width' => '140px',
                'value' => function ($model) {
                    return $model->refundApplication->refundInternalOperationalSetting->name;
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
                                        return Html::label("Preview Complete", NULL, ['class'=>'label label-success']);
                                    }
                                   else if($model->current_status==6) {
                                        return Html::label("Verification Onprogress", NULL, ['class'=>'label label-warning']);
                                    }
                                  else if($model->current_status==7) {
                                        return Html::label("Verification Complete", NULL, ['class'=>'label label-primary']);
                                    }
                        },
                        'format' => 'raw'
                    ],              
             [
               'label'=>'',
               'value'=>function($model){
                  return Html::a("Verify", ['/repayment/refund-application-operation/view-refundlevel','id'=>$model->refund_application_id], ['class'=>'label label-primary']);
               },
               'format'=>'raw',
             ],
        ],
    ]); ?>
</div>
</div>
</div>
