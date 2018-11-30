 <?php
 
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\date\DatePicker;
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

$this->title = 'Pre-Paid';
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
            <?= $form->field($model, 'payment_date')->label('From')->widget(DatePicker::classname(), [
           'name' => 'payment_date', 	
    'options' => ['placeholder' => 'Enter date (yyyy-mm-dd)',
                  'todayHighlight' => true,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>
       </div>
        <div class="col-md-6">
           <?= $form->field($model, 'payment_date2')->label('To')->widget(DatePicker::classname(), [
           'name' => 'payment_date2', 	
    'options' => ['placeholder' => 'Enter date (yyyy-mm-dd)',
                  'todayHighlight' => true,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>
       </div>
    </div>
                <div class="text-right">
                    <?= Html::submitButton($model->isNewRecord ? 'Process' : 'Process', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
</div>
       </div>
	    </div>