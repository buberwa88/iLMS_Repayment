<div class="form-group" id="add-complaint">
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
    'formName' => 'Complaint',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'complaint_id' => ['type' => TabularForm::INPUT_HIDDEN],
        'complaint' => ['type' => TabularForm::INPUT_TEXTAREA],
        'applicant_id' => ['type' => TabularForm::INPUT_TEXT],
        'complaint_parent_id' => [
            'label' => 'Complaint',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\appeal\models\Complaint::find()->orderBy('complaint')->asArray()->all(), 'complaint_id', 'complaint'),
                'options' => ['placeholder' => 'Choose Complaint'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'complaint_response' => ['type' => TabularForm::INPUT_TEXTAREA],
        'status' => ['type' => TabularForm::INPUT_TEXT],
        'level' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowComplaint(' . $key . '); return false;', 'id' => 'complaint-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Complaint', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowComplaint()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

