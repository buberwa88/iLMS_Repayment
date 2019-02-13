<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'List of Disbursed Loan';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">
         
          
        </div>
        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProviderDisbursement,
        //'filterModel' => $searchModel,
        'hover' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model){
                  return $this->render('disbursed_loan_item',['model'=>$model,'application_id'=>$model->application_id,'academic_year_id'=>$model->disbursementBatch->academic_year_id,'applicant_id'=>$model->application->applicant_id]); 
                  //return $this->render('index',['model'=>$model]); 
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
            ],
              
                    [
                     'attribute' => 'academic_year_id',
                        'label'=>'Academic Year',                        
                        'value' => function($model, $index, $dataColumn) {                        
                           return $model->disbursementBatch->academicYear->academic_year;
                        },
                    ],
                            
                     /*           
                                [
                     'attribute' => 'semester_number',
                     'label'=>'Semister',
                        'filter' => \frontend\modules\application\models\Application::dropdownDisbSermister(),
                        'value' => function($model, $index, $dataColumn) {
                        $roleDropdown=\frontend\modules\application\models\Application::dropdownDisbSermister();
                           return $roleDropdown[$model->disbursementBatch->semester_number];
                        },
                    ],
                    [
                     'attribute' => 'instalment_definition_id',
                     'label'=>'Instalment',
                        'filter' => \frontend\modules\application\models\Application::dropdownDisbInstalment(),
                        'value' => function($model, $index, $dataColumn) {
                        $roleDropdown=\frontend\modules\application\models\Application::dropdownDisbInstalment();
                           return $roleDropdown[$model->disbursementBatch->instalment_definition_id];
                        },
                    ],
                                 * 
                                 */
                               
                    [
                'attribute' => 'disbursed_amount',
                'label'=>'Amount',        
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) {           
                return \frontend\modules\application\models\Application::getTotalDisbursedLoanheslb($model->application_id,$model->disbursementBatch->academic_year_id,$model->application->applicant_id);
        },
            ],            
                   
        ],
    ]); ?>
</div>
</div>
</div>
