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
$yearmax = date("Y");
for ($y = 1982; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
?>
<style>
.rowQA {
  width: 100%;
  /*margin: 0 auto;*/
    text-align: center;
}
.block {
  width: 100px;
  /*float: left;*/
    display: inline-block;
    zoom: 1;
}
</style>
<?php
     $incomplete=0;
//$this->title ='Application for Refund, Select the Refund Type:';
//$this->params['breadcrumbs'][] = 'Refund Application';
?>
<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-body">
                    <?php
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'options' => ['enctype' => 'multipart/form-data'],
        'enableClientValidation' => TRUE,]);
    ?>
    <?php
    echo Form::widget([ // fields with labels
        'model'=>$model,
        'form'=>$form,
        'columns'=>1,
        'attributes'=>[
            'bank_name'=>['label'=>'Bank Name:', 'options'=>['placeholder'=>'Enter.']],
            'bank_account_number'=>['label'=>'Account Number:', 'options'=>['placeholder'=>'Enter.']],
            'bank_account_name'=>['label'=>'Account Name:', 'options'=>['placeholder'=>'Enter.']],
            'branch'=>['label'=>'Branch:', 'options'=>['placeholder'=>'Enter.']],
        ]
    ]);
    ?>
        <?php
            echo $form->field($model, 'bank_card_document')->label('Bank Card Document:')->widget(FileInput::classname(), [
                'options' => ['accept' => 'site/pdf'],
                'pluginOptions' => [
                    'showCaption' => false,
                    'showRemove' => TRUE,
                    'showUpload' => false,
                    //'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                    'browseLabel' =>  'Bank Card Document (required format .pdf only)',
                    'initialPreview'=>[
                        '$model->bank_card_document',
                    ],
                    'initialCaption'=>$model->bank_card_document,
                    'initialPreviewAsData'=>true,
                ],
                //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
            ]);
            ?>
	  <br/></br/>
		<div class="rowQA">	 
	 <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK",['site/list-steps-nonbeneficiary','id'=>$refundClaimantid]);?></div>
<div class="block pull-CENTER"><?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Update') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'create-button-id']
        );?></div>
		<div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/index-tertiary-education']);?></div>
</div>
       <?php        
        ActiveForm::end();
        ?>
        </div>
</div>
</div>




 
