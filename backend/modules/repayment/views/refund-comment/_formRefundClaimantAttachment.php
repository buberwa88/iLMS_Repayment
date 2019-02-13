<div class="form-group" id="add-refund-claimant-attachment">
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
    'formName' => 'RefundClaimantAttachment',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'refund_claimant_attachment_id' => ['type' => TabularForm::INPUT_HIDDEN],
        'refund_application_id' => [
            'label' => 'Refund application',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\RefundApplication::find()->orderBy('refund_application_id')->asArray()->all(), 'refund_application_id', 'refund_application_id'),
                'options' => ['placeholder' => 'Choose Refund application'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'attachment_definition_id' => [
            'label' => 'Attachment definition',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\AttachmentDefinition::find()->orderBy('attachment_definition_id')->asArray()->all(), 'attachment_definition_id', 'attachment_definition_id'),
                'options' => ['placeholder' => 'Choose Attachment definition'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'attachment_path' => ['type' => TabularForm::INPUT_TEXT],
        'verification_status' => ['type' => TabularForm::INPUT_TEXT],
        'other_description' => ['type' => TabularForm::INPUT_TEXT],
        'last_verified_by' => [
            'label' => 'User',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\User::find()->orderBy('username')->asArray()->all(), 'user_id', 'username'),
                'options' => ['placeholder' => 'Choose User'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'last_verified_at' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
                'saveFormat' => 'php:Y-m-d H:i:s',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Last Verified At',
                        'autoclose' => true,
                    ]
                ],
            ]
        ],
        'is_active' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowRefundClaimantAttachment(' . $key . '); return false;', 'id' => 'refund-claimant-attachment-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Refund Claimant Attachment', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowRefundClaimantAttachment()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

