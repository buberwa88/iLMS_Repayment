<div class="form-group" id="add-refund-verification-framework-item">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;
use frontend\modules\application\models\AttachmentDefinition;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'RefundVerificationFrameworkItem',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'refund_verification_framework_item_id' => ['label'=>"",'type' => TabularForm::INPUT_HIDDEN],
        'attachment_definition_id' => [
            'label' => 'Attachment ',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(AttachmentDefinition::find()->orderBy('attachment_definition_id')->asArray()->all(), 'attachment_definition_id', 'attachment_desc'),
                'options' => ['placeholder' => 'Choose Attachment'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'verification_prompt' => ['type' => TabularForm::INPUT_TEXT],
        'status' => 
        [
            'label' => 'Priority',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' =>[1=>"Mandatory",2=>'Optional'],
                'options' => ['placeholder' => 'Choose  Priority'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'is_active' => 
        [
            'label' => 'Status',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => [1=>"Active",0=>'Inactive'],
                'options' => ['placeholder' => 'Choose  Status'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowRefundVerificationFrameworkItem(' . $key . '); return false;', 'id' => 'refund-verification-framework-item-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Refund Verification Framework Item', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowRefundVerificationFrameworkItem()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

