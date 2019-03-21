<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundInternalOperationalSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-internal-operational-setting-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=
    $form->field($model, 'flow_type')->dropDownList(
            $model->getFlowTypes(), ['prompt' => ' -- select --']
    );
    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    
	<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [	
		'code' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Code',
            'options' => [
                'data' =>\backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationResponCode(),
                'options' => [
                    'prompt' => 'Select ',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
		
    ]
]);
?>

    <?=
    $form->field($model, 'access_role_master')->widget(kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(common\models\AuthItemChild::find()->asArray()->all(), 'parent', 'parent'),
        'options' => ['placeholder' => '-- Select --', 'multiple' => FALSE],
        'pluginOptions' => [
            'allowClear' => true,
//            'minimumInputLength' => 2
        ],
    ]);
    ?>

    <?=    
     $form->field($model, 'access_role_child')->widget(kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(common\models\AuthItemChild::find()->asArray()->all(), 'parent', 'parent'),
        'options' => ['placeholder' => '-- Select --', 'multiple' => FALSE],
        'pluginOptions' => [
            'allowClear' => true,
//            'minimumInputLength' => 2
        ],
    ]);
    ?>

    <?=
    $form->field($model, 'flow_order_list')->dropDownList(
            Yii::$app->params['priority_order_list'], ['prompt' => ' -- select --']
    );
    ?>
    <?= $form->field($model, 'approval_comment')->textInput(['maxlength' => true, 'placeholder' => 'Approval Comment']) ?>
    <?= $form->field($model, 'approval_status')->textInput(['maxlength' => true, 'placeholder' => 'Approval Status']) ?>
    <?=
    $form->field($model, 'is_active')->dropDownList(
            $model->getStatusList()
    );
    ?>
    <div class="form-group">
        <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
