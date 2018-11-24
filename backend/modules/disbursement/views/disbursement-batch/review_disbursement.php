<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementBatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Disbursement';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-batch-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                  //'disbursement_batch_id',
                     [
                     'attribute' => 'learning_institution_id',
                        'vAlign' => 'middle',
                         
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->learningInstitution->institution_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\application\models\LearningInstitution::find()->asArray()->all(), 'learning_institution_id', 'institution_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    [
                     'attribute' => 'allocation_batch_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->allocationBatch->batch_number;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\AllocationBatch::find()->asArray()->all(), 'allocation_batch_id', 'batch_number'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
            //'allocation_batch_id',
             [
                        'attribute' => 'academic_year_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->academicYear->academic_year;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\common\models\AcademicYear::find()->where("is_current=1")->asArray()->all(), 'academic_year_id', 'academic_year'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'instalment_definition_id',
                        'vAlign' => 'middle',
                        'label'=>"Instalment",
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->instalmentDefinition->instalment;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(backend\modules\disbursement\models\InstalmentDefinition::find()->asArray()->all(), 'instalment_definition_id', 'instalment'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],             
            // 'batch_number',
            /// 'batch_desc',
             //'instalment_type',
            // 'is_approved',
            // 'approval_comment:ntext',
            // 'institution_payment_request_id',
            // 'payment_voucher_number',
            // 'cheque_number',
            // 'created_at',
            // 'created_by',

             ['class' => 'yii\grid\ActionColumn',
             'template' => '{viewreviewb}',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil" title="Edit"></span>',
                            $url);
                    },
                      'viewreviewb' => function ($url,$model,$key) {
                            return Html::a('<span class="green">View Detail</span>', $url);
                    },

                ],
                ],
        ],
    ]); ?>
</div>
 </div>
</div>