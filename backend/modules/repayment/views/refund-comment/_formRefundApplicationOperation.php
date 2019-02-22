<div class="form-group" id="add-refund-application-operation">
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
    'formName' => 'RefundApplicationOperation',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'refund_application_operation_id' => ['type' => TabularForm::INPUT_HIDDEN],
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
        'refund_internal_operational_id' => [
            'label' => 'Refund internal operational setting',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\RefundInternalOperationalSetting::find()->orderBy('name')->asArray()->all(), 'refund_internal_operational_id', 'name'),
                'options' => ['placeholder' => 'Choose Refund internal operational setting'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'access_role' => ['type' => TabularForm::INPUT_TEXT],
        'status' => ['type' => TabularForm::INPUT_TEXT],
        'narration' => ['type' => TabularForm::INPUT_TEXT],
        'assignee' => [
            'label' => 'User',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\User::find()->orderBy('username')->asArray()->all(), 'user_id', 'username'),
                'options' => ['placeholder' => 'Choose User'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'assigned_at' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
                'saveFormat' => 'php:Y-m-d H:i:s',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Assigned At',
                        'autoclose' => true,
                    ]
                ],
            ]
        ],
        'assigned_by' => [
            'label' => 'User',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\User::find()->orderBy('username')->asArray()->all(), 'user_id', 'username'),
                'options' => ['placeholder' => 'Choose User'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
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
        'is_current_stage' => ['type' => TabularForm::INPUT_TEXT],
        'date_verified' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
                'saveFormat' => 'php:Y-m-d H:i:s',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Date Verified',
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
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowRefundApplicationOperation(' . $key . '); return false;', 'id' => 'refund-application-operation-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Refund Application Operation', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowRefundApplicationOperation()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

