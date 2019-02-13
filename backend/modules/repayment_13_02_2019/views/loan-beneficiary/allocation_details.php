<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'List of Allocated Loan';
//$this->params['breadcrumbs'][] = $this->title;
$applicationID = $model->application_id;
?>
<div class="panel-heading">
</div>
<div class="panel-body">
    <?=
    GridView::widget([
        'dataProvider' => \common\models\LoanBeneficiary::getBeneficiaryLoanAllocationByApplicantID($model->applicant_id),
        //'filterModel' => $searchModel,
        'hover' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            [
//                'class' => 'kartik\grid\ExpandRowColumn',
//                'value' => function ($model, $key, $index, $column) {
//                    return GridView::ROW_COLLAPSED;
//                },
//                'allowBatchToggle' => true,
//                'detail' => function ($model) {
//                    return $this->render('allocated_loan_item', ['model' => $model, 'application_id' => $model->application_id, 'allocation_batch_id' => $model->allocation_batch_id]);
//                    //return $this->render('index',['model'=>$model]); 
//                },
//                        'detailOptions' => [
//                            'class' => 'kv-state-enable',
//                        ],
//                    ],
            [
                'label' => 'Academic Year',
                'value' => function($model) {
                    return $model->allocationBatch->academicYear->academic_year;
                },
            ],
            [
                'label' => 'Date',
                'value' => function($model) {
                    return date('d-M-Y', strtotime($model->allocationBatch->created_at));
                },
            ],
            [
                'label' => 'Batch Desc',
                'value' => function($model) {
                    return $model->allocationBatch->batch_desc;
                },
            ],
            [
                'label' => 'Batch #',
                'value' => function($model) {
                    return $model->allocationBatch->batch_number;
                },
            ],
            [
                'attribute' => 'allocated_amount',
                'value' => function ($model) {
                    return backend\modules\allocation\models\Allocation::find()->where(['application_id' => $model->application_id, 'allocation_batch_id' => $model->allocation_batch_id, 'allocation.is_canceled' => 0])->sum('allocated_amount');
                },
                        'hAlign' => 'right',
                        'format' => ['decimal', 2],
                        'label' => "Total Amount",
                        'width' => '130px',
                    ],
                ],
            ]);
            ?>
</div>

