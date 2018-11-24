<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Allocated Loan';
$this->params['breadcrumbs'][] = $this->title;
$applicationID=$model->application_id;
?>
<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                  return $this->render('allocated_loan_item',['model'=>$model,'application_id'=>$model->application_id,'academicYearID'=>$model->allocationBatch->academic_year_id]); 
                  //return $this->render('index',['model'=>$model]); 
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
            ],
              
                    [
                     'attribute' => 'academic_year_id',
                        'label'=>'Academic Year',
                        'filter' => \frontend\modules\application\models\Application::dropdownq(),
                        'value' => function($model, $index, $dataColumn) {
                        $roleDropdown=\frontend\modules\application\models\Application::dropdownq();
                           return $roleDropdown[$model->allocationBatch->academic_year_id];
                        },
                    ],
                    [
                'attribute' => 'allocated_amount',
                'label'=>'Amount',        
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) {
                return \frontend\modules\application\models\Application::getTotalLoanAllocatedPerAcademicYear($model->application_id,$model->allocationBatch->academic_year_id);
        },
            ],            
                   
        ],
    ]); ?>
</div>
</div>
</div>
