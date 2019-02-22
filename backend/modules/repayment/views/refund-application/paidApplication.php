<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Paid Refund Applications';
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
    <?php  echo $this->render('_search_application_verification', ['model' => $searchModel,'action'=>'paid-application']); ?>
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
                'attribute' => 'refund_claimant_amount',
                'label'=>"Amount",
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->current_status ==-1 ?  Html::a($model->refund_claimant_amount, ['/repayment/refund-application-operation/view-verifref','id'=>$model->refund_application_id]) : $model->refund_claimant_amount;
                },
            ],
                   [
                     'attribute' => 'current_status',
                       'label'=>'Status',
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->current_status ==0){
                                     return $model->current_status ==-1 ?  Html::label("Unvarified", NULL, ['class'=>'label label-default']) : "Unvarified";
                                    } else if($model->current_status==1) {
                                        return $model->current_status ==-1 ?  Html::label("Preview Complete", NULL, ['class'=>'label label-success']) : "Preview Complete";
                                    }
                                   else if($model->current_status==6) {
                                        return $model->current_status ==-1 ?  Html::label("Verification Onprogress", NULL, ['class'=>'label label-warning']) : "Verification Onprogress";
                                    }
                                  else if($model->current_status==7) {
                                        return $model->current_status ==-1 ?  tml::label("Verification Complete", NULL, ['class'=>'label label-primary']):"Verification Complete";
                                    }
                        },
                        'format' => 'raw'
                    ],
        ],
    ]); ?>
</div>
</div>
</div>
