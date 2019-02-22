<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\captcha\Captcha;
use kartik\widgets\FileInput;
$yearmax = date("Y");
for ($y = 1982; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
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
                    $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_VERTICAL,
                    'options' => ['enctype' => 'multipart/form-data'],
                    'enableClientValidation' => TRUE,

                    ]);
                    ?>
     <?php
      echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 2,
                        'attributes' => [
       'trustee_firstname' => ['type' => Form::INPUT_TEXT, 'label' => 'Trustee First Name', 'options' => ['placeholder' => 'Enter ']],
       'trustee_midlename' => ['type' => Form::INPUT_TEXT, 'label' => 'Trustee Middle Name', 'options' => ['placeholder' => 'Enter .']],
       'trustee_surname' => ['type' => Form::INPUT_TEXT, 'label' => 'Trustee Last Name', 'options' => ['placeholder' => 'Enter .']],
                        ]
                    ]);
      ?>
            <?php
            echo $form->field($model, 'letter_family_session_document')->label('Family Session Letter Document:')->widget(FileInput::classname(), [
                'options' => ['accept' => 'site/pdf'],
                'pluginOptions' => [
                    'showCaption' => false,
                    'showRemove' => TRUE,
                    'showUpload' => false,
                    // 'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                    'browseLabel' =>  'Family Session Letter Document (required format .pdf only)',
                    'initialPreview'=>[
                        "$model->letter_family_session_document",

                    ],
                    'initialCaption'=>$model->letter_family_session_document,
                    'initialPreviewAsData'=>true,
                ],
                //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
            ]);
            ?>
	  <br/></br/>
		<div class="rowQA">	 
	 <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK",['site/refund-liststeps']);?></div>
<div class="block pull-CENTER"><?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'create-button-id']
        );?></div>
		<div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/refund-applicationview','refundApplicationID' => $refund_application_id]);?></div>
</div>
       <?php        
        ActiveForm::end();
        ?>
        </div>
</div>
</div>




 
