 <?php
 
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\date\DatePicker;
use kartik\detail\DetailView;
/*
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
 * 
 */

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'GePG Payment';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appleal-default-index">
<div class="panel panel-info">
<div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body"> 
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'enableClientValidation' => TRUE]); ?>
                <div class="row">
        <div class="col-md-6">
<?= $form->field($model, 'control_number')->textInput(['placeholder'=>'Control Number']) ?>
       </div>
	   <div class="col-md-6">
<?= $form->field($model, 'amount')->textInput(['placeholder'=>'Amount']) ?>
       </div>
        <div class="col-md-6">
           <?php
                            echo Form::widget([// fields with labels
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'payCategory' => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => 'Category',
                                        'options' => [
                                            'data' => \frontend\modules\repayment\models\LoanRepaymentPrepaid::getGePGpaymentCategory(),
                                            'options' => [
                                                'prompt' => '-- Select --',
                                            ],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                            ]]);
                            ?>
       </div>
    </div>
                <div class="text-right">
                    <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
				<?php ActiveForm::end(); ?>
</div>
       </div>
	    </div>