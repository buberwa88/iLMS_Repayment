<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pay List of Refund Applications';
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
    <?php  echo $this->render('_search_application_verification', ['model' => $searchModel,'action'=>'waiting-letter']); ?>
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
                            return $model->current_status ==-1 ? Html::a($model->firstname, ['/repayment/refund-application-operation/view-verifref','id'=>$model->refund_application_id]):$model->firstname;
                        },
                    ],
                    [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->current_status ==-1 ? Html::a($model->middlename, ['/repayment/refund-application-operation/view-verifref','id'=>$model->refund_application_id]) : $model->middlename;
                        },
                    ],
                    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->current_status ==-1 ? Html::a($model->surname, ['/repayment/refund-application-operation/view-verifref','id'=>$model->refund_application_id]) : $model->surname;
                        },
                    ],
            [
                'attribute' => 'refund_type_id',
                'label'=>'Category',
                'width' => '140px',
                'value' => function ($model) {
                    if($model->refund_type_id ==1){
                        //return "Non Beneficiary";
                        return $model->current_status ==-1 ? Html::a("Non Beneficiary", ['/repayment/refund-application-operation/view-verifref','id'=>$model->refund_application_id]) : "Non Beneficiary";
                    } else if($model->refund_type_id==2) {
                        //return "Over Deducted";
                        return $model->current_status ==-1 ? Html::a("Over Deducted", ['/repayment/refund-application-operation/view-verifref','id'=>$model->refund_application_id]) : "Over Deducted";
                    }
                    else if($model->refund_type_id==3) {
                        //return "Deceased";
                        return $model->current_status ==-1 ?  Html::a("Deceased", ['/repayment/refund-application-operation/view-verifref','id'=>$model->refund_application_id]) : "Deceased";
                    }
                },
                'format' => 'raw'
            ],
            [
                'attribute'=>'refund_claimant_amount',
                'label'=>"Amount",
                'format'=>'raw',
                'value' =>function($model)
                {
                    return $model->refund_claimant_amount;
                },
                'format'=>['decimal',2],
                'hAlign' => 'right',
            ],
                   [
                     'attribute' => 'current_status',
                       'label'=>'Status',
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->current_status ==8){
                                     return $model->current_status ==-1 ?  Html::label("Waiting", NULL, ['class'=>'label label-default']) : "Waiting";
                                    } else {
                                        return $model->current_status ==-1 ?  Html::label("Paid", NULL, ['class'=>'label label-success']) : "Paid";
                                    }

                        },
                        'format' => 'raw'
                    ],
        ],
    ]); ?>
</div>
</div>
</div>
