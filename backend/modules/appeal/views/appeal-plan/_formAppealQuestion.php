<div class="form-group" id="add-appeal-question">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'AppealQuestion',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'appeal_question_id' => ['type' => TabularForm::INPUT_HIDDEN,'label'=>''],
        'question_id' => [
            'label' => 'Question',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\appeal\models\Question::find()->orderBy('question')->asArray()->all(), 'question_id', 'question'),
                'options' => ['placeholder' => 'Choose Question'],
            ],
            //'columnOptions' => ['width' => '200px']
        ],
        'attachment_definition_id' => [
            'label' => 'Attachment definition',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\appeal\models\AttachmentDefinition::find()->orderBy('attachment_definition_id')->asArray()->all(), 'attachment_definition_id', 'attachment_desc'),
                'options' => ['placeholder' => 'Choose Attachment definition'],
            ],
            'columnOptions' => ['width' => '300px']
        ],
        'status' => [
            'label' => 'Status',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' =>[1=>'Active',0=>'InActive'],
                'options' => ['placeholder' => 'Choose Status'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowAppealQuestion(' . $key . '); return false;', 'id' => 'appeal-question-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Appeal Question', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowAppealQuestion()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

