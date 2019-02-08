<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\captcha\Captcha;
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
                    $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_VERTICAL,
                    'enableClientValidation' => TRUE,

                    ]);
                    ?>
     <?= $form->field($model, 'is_necta')->label(false)->hiddenInput(['value'=>22,'maxlength' => true]) ?>
        <?php
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'id' => "school_block_id",
            'columns' => 2,
            'attributes' => [
                'f4indexno' => ['type' => Form::INPUT_TEXT, 'label' => 'F4 Index #',

         'options' => ['maxlength'=>10,'placeholder' => '',
             //'onchange' => 'check_necta()',
             'data-toggle' => 'tooltip',
            'data-placement' =>'top','title' => '']],
                'f4_completion_year' => ['type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\select2\Select2::className(),
                    'label' => 'Completion Year',
                    'options' => [
                        'data' => $year,
                        'options' => [
                            'prompt' => 'Select Completion Year',
                            //'onchange' => 'check_necta()'
                        //'id'=>'entry_year_id'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ],
                ],
            ]
        ]);
       ?>
     <?php
      echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 2,
                        'id' => "nonnecta_block_id",
                        'attributes' => [
       'necta_firstname' => ['type' => Form::INPUT_TEXT, 'label' => 'First Name', 'options' => ['placeholder' => 'Enter ']],
       'necta_middlename' => ['type' => Form::INPUT_TEXT, 'label' => 'Middle Name', 'options' => ['placeholder' => 'Enter .']],
       'necta_surname' => ['type' => Form::INPUT_TEXT, 'label' => 'Last Name', 'options' => ['placeholder' => 'Enter .']],
                        ]
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




 
