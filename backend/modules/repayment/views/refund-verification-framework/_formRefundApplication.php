<div class="form-group" id="add-refund-application">
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
    'formName' => 'RefundApplication',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'refund_application_id' => ['type' => TabularForm::INPUT_HIDDEN],
        'refund_claimant_id' => [
            'label' => 'Refund claimant',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\RefundClaimant::find()->orderBy('refund_claimant_id')->asArray()->all(), 'refund_claimant_id', 'refund_claimant_id'),
                'options' => ['placeholder' => 'Choose Refund claimant'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'application_number' => ['type' => TabularForm::INPUT_TEXT],
        'refund_claimant_amount' => ['type' => TabularForm::INPUT_TEXT],
        'finaccial_year_id' => [
            'label' => 'Financial year',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\FinancialYear::find()->orderBy('financial_year')->asArray()->all(), 'financial_year_id', 'financial_year'),
                'options' => ['placeholder' => 'Choose Financial year'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'academic_year_id' => [
            'label' => 'Academic year',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\AcademicYear::find()->orderBy('academic_year')->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => ['placeholder' => 'Choose Academic year'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'trustee_firstname' => ['type' => TabularForm::INPUT_TEXT],
        'trustee_midlename' => ['type' => TabularForm::INPUT_TEXT],
        'trustee_surname' => ['type' => TabularForm::INPUT_TEXT],
        'trustee_phone_number' => ['type' => TabularForm::INPUT_TEXT],
        'trustee_email' => ['type' => TabularForm::INPUT_TEXT],
        'trustee_sex' => ['type' => TabularForm::INPUT_TEXT],
        'current_status' => ['type' => TabularForm::INPUT_TEXT],
        'check_number' => ['type' => TabularForm::INPUT_TEXT],
        'bank_account_number' => ['type' => TabularForm::INPUT_TEXT],
        'bank_account_name' => ['type' => TabularForm::INPUT_TEXT],
        'bank_id' => [
            'label' => 'Bank',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\repayment\models\Bank::find()->orderBy('bank_id')->asArray()->all(), 'bank_id', 'bank_id'),
                'options' => ['placeholder' => 'Choose Bank'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'refund_type_id' => ['type' => TabularForm::INPUT_TEXT],
        'liquidation_letter_number' => ['type' => TabularForm::INPUT_TEXT],
        'is_active' => ['type' => TabularForm::INPUT_TEXT],
        'submitted' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowRefundApplication(' . $key . '); return false;', 'id' => 'refund-application-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Refund Application', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowRefundApplication()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

