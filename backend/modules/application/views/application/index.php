<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'application_id',
           // 'applicant_id',
              [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
                    ],
                    [
                     'attribute' => 'surname',
                         'label'=>"Last Name",
                        'vAlign' => 'middle',
                         
                       // 'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
                    ],
                    [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->educations->registration_number;
                        },
                    ],
                   /* [
                     'attribute' => 'application_study_year',
                       // 'label'=>"f4 Index #",
                        'vAlign' => 'middle',
                        'width' => '120px',
                        'value' => function ($model) {
                            return $model->application_study_year;
                        },
                       'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[1=>1,2=>2,3=>3,4=>4,5=>5],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],*/
                   [
                     'attribute' => 'verification_status',
                       // 'label'=>"f4 Index #",
                        'vAlign' => 'middle',
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
                       'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[0=>"Unvarified",1=>'Complete',2=>'Incomplete',3=>'Waiting'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],              
            //'academic_year_id',
            //'bill_number',
            ///'control_number',
            // 'receipt_number',
            // 'amount_paid',
            // 'pay_phone_number',
            // 'date_bill_generated',
            // 'date_control_received',
            // 'date_receipt_received',
            // 'programme_id',
            // 'application_study_year',
            // 'current_study_year',
            // 'applicant_category_id',
            // 'bank_account_number',
            // 'bank_account_name',
            // 'bank_id',
            // 'bank_branch_name',
            // 'submitted',
           //  'verification_status',
            // 'needness',
            // 'allocation_status',
            // 'allocation_comment',
            // 'student_status',
            // 'created_at',
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
          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
