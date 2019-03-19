<?php
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use frontend\modules\application\models\AttachmentDefinition;

$this->title = 'Refund Rejection Reasons Setting';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="refund-comment-index">

    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create/Add Refund Rejection Reason', ['create'], ['class' => 'btn btn-success']) ?>

            </p>

            <?php
            $gridColumn = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'attachment_definition_id',
                    'label' => 'Attachment',
                    'value' => function($model) {
                        if ($model->attachmentDefinition) {
                            return $model->attachmentDefinition->attachment_desc;
                        } else {
                            return NULL;
                        }
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => \yii\helpers\ArrayHelper::map(AttachmentDefinition::find()->asArray()->all(), 'attachment_definition_id', 'attachment_desc'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Attachment definition', 'id' => 'grid-refund-comment-search-attachment_definition_id']
                ],
                [ 'attribute' => 'reason_type',
                    'value' => function($model) {
                        return strtoupper($model->getReasonGroupName());
                    },
                ],
                'comment',
                //'is_active',
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
                    'template' => '{update} {delete}',
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
                        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-refund-comment']],
                        'export' => false,
                            // your toolbar can include the additional full export menu
                    ]);
                    ?>

        </div>
    </div>
</div>

