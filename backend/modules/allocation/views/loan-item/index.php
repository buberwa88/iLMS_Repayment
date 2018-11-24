<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\LoanItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Loan Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-item-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create Loan Item', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'loan_item_id',
                    'item_name',
                    'item_code',
                    [
                        'attribute' => 'rate_type',
//                        'label' => 'Current Rate',
                        'value' => function($model) {
                            return backend\modules\allocation\models\LoanItem::getLoanItemRateNameByItemId($model->loan_item_id);
                        }
                    ],
                    'loan_item_category',
                    [
                        'attribute' => 'study_level',
                        'value' => 'studyLevel.applicant_category',
                    ],
                    [
                        'attribute' => 'is_active',
                        'vAlign' => 'middle',
//                        'label' => "Status",
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->getStatusNameByValue();
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [1 => 'Active', 0 => 'Inactive'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}'],
                ],
                'hover' => true,
                'condensed' => true,
                'floatHeader' => true,
            ]);
            ?>
        </div>
    </div>
</div>