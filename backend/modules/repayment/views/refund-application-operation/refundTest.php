<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use frontend\modules\repayment\models\EmployerSearch;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */

$this->title ="Refund Application Verification";
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Refund', 'url' => Yii::$app->request->referrer];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>
               <?php
               echo Form::widget([ // fields with labels
                   'model'=>$modelRefundAppOper,
                   'form'=>$form,
                   'columns'=>2,
                   'attributes'=>[
                       //'verificationStatus'=>['label'=>'Verification Status:', 'options'=>['placeholder'=>'Enter.']],
                       /*
                       'verificationStatus' => [
                           'type' => Form::INPUT_DROPDOWN_LIST,                           
                           'options' => [
						   'items' => \backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationStatus(),
                               'options' => [
                                   'prompt' => ' Select ',
                                   'id' => 'verificationStatus_id',
                               ],
                               ],
                       ],
					   */
					   
					   'verificationStatus' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => \backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationStatus(),
                    'options' => [
                        'prompt' => ' Select Learning Institution ',
                        'id' => 'verificationStatus_id',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],

                       'refund_statusreasonsettingid' => ['type' => Form::INPUT_WIDGET,
                           'widgetClass' => \kartik\select2\Select2::className(),
                           'label' => 'Comment',
                           'widgetClass' => DepDrop::className(),
                           'options' => [
                               'data' => ArrayHelper::map(backend\modules\repayment\models\RefundStatusReasonSetting::find()->all(), 'refund_status_reason_setting_id', 'reason'),
                               'options' => [
                                   'prompt' => ' Select ',
                                   'id' => 'refund_statusreasonsettingid_id',
                               ],
                               'pluginOptions' => [
                                   'depends' => ['verificationStatus_id'],
                                   'placeholder' => 'Select ',
                                   'url' => Url::to(['/repayment/employer/setting-reasons']),								   
                               ],
                           ],
                       ],

                       //'refund_statusreasonsettingid'=>['label'=>'Comment', 'options'=>['placeholder'=>'Enter.']],
                     ]
               ]);
               ?>
               <?= $form->field($modelRefundAppOper, 'narration')->label('Narration')->textInput() ?>
               <?= $form->field($modelRefundAppOper, 'refund_application_id')->label(FALSE)->hiddenInput(["value" =>$application_id1]) ?>
               <div class="text-right">
                   <?= Html::submitButton($modelRefundAppOper->isNewRecord ? 'SAVE' : 'SAVE', ['class' => $modelRefundAppOper->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                   <?php
                   echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
                   echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/refund-application-operation/verifyapplication','id'=>$application_id1], ['class' => 'btn btn-warning']);

                   ActiveForm::end();
                   ?>