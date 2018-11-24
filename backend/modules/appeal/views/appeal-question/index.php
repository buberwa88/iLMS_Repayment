<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Appeal Question';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="appeal-question-index">
    
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        
        <div class="panel-body">

            <br/>
        
            <p>
                <?= Html::a('Create Appeal Question', ['create'], ['class' => 'btn btn-success pull-right']) ?>
            </p>
            <br/><br/>

            <?php 
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                
                    [
                            'attribute' => 'question_id',
                            'label' => 'Question',
                            'value' => function($model){                   
                                return $model->question->question;                   
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => \yii\helpers\ArrayHelper::map(\backend\modules\appeal\models\Question::find()->asArray()->all(), 'question_id', 'question'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Question', 'id' => 'grid--question_id']
                        ],
                        [
                            'attribute' => 'attachment_definition_id',
                            'label' => 'Attachment Definition',
                            'value' => function($model){                   
                                return $model->attachmentDefinition->attachment_desc;                   
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => \yii\helpers\ArrayHelper::map(\backend\modules\appeal\models\AttachmentDefinition::find()->asArray()->all(), 'attachment_definition_id', 'attachment_definition_desc'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Attachment definition', 'id' => 'grid--attachment_definition_id']
                        ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                    ],
                ]; 
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumn,
                    'pjax' => true,
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-appeal-question']],
                
                    'export' => false,
                    // your toolbar can include the additional full export menu
                    'toolbar' => [
                        '{export}',
                        ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumn,
                            'target' => ExportMenu::TARGET_BLANK,
                            'fontAwesome' => true,
                            'dropdownOptions' => [
                                'label' => 'Full',
                                'class' => 'btn btn-default',
                                'itemsBefore' => [
                                    '<li class="dropdown-header">Export All Data</li>',
                                ],
                            ],
                            'exportConfig' => [
                                ExportMenu::FORMAT_PDF => false
                            ]
                        ]) ,
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
