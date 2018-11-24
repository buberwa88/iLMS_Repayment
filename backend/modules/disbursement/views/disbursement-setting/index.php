<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disbursement Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-setting-index">
    <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
            <?= Html::a('Create Disbursement Setting', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'disbursement_setting_id',
                    [
                        'attribute' => 'academic_year_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->academicYear->academic_year;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(common\models\AcademicYear::find()->where("is_current=1")->asArray()->all(), 'academic_year_id', 'academic_year'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'instalment_definition_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->instalmentDefinition->instalment;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\disbursement\models\InstalmentDefinition::find()->where("is_active=1")->asArray()->all(), 'instalment_definition_id', 'instalment'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'loan_item_id',
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->loanItem->item_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where("is_active=1")->asArray()->all(), 'loan_item_id', 'item_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search  '],
                        'format' => 'raw'
                    ],
                    'percentage',
                    ['class' => 'yii\grid\ActionColumn',
                        'template'=>'{update}{delete}'],
                ],
          'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
            ]);
            ?>
        </div>
    </div></div>