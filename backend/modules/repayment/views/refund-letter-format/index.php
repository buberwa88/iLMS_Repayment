<?php
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundLetterFormatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Refund Letter Configurations';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="refund-letter-format-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create/Add Refund Letter Setting', ['create'], ['class' => 'btn btn-success']) ?>

            </p>

            <?php
            $gridColumn = [
                ['class' => 'yii\grid\SerialColumn'],
                //'refund_letter_format_id',
                'letter_name',
                //'header',
                //'footer',
                'letter_heading',
                'letter_reference_no:ntext',
                // 'is_active',
                [
                    'attribute' => 'is_active',
                    'label' => 'Status',
                    'value' => function($model) {
                        if ($model->is_active) {
                            return $model->is_active == 1 ? "Active" : "Inactive";
                        } else {
                            return NULL;
                        }
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => [1 => "Active", 0 => "Inactive"],
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Status', 'id' => 'grid-status-search']
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'save-as-new' => function ($url) {
                            return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, ['title' => 'Save As New']);
                        },
                            ],
                        ],
                    ];
                    ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => $gridColumn,
                        'pjax' => true,
                        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-refund-letter-format']],
                        'export' => false,
                            // your toolbar can include the additional full export menu
                    ]);
                    ?>

        </div>
    </div>
</div>
