<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\captcha\Captcha;
$yearmax = date("Y");
for ($y = 1982; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}
?>
<style>
    iframe{
        border: 0;
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
            <div class="col-lg-12">
                    <?php
                    $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_VERTICAL,
                    'enableClientValidation' => TRUE,
					'action' => ['create-refundf4educationnonnecta'], 
					'options' => ['method' => 'post']
                    ]);
                    ?>
               <div class="alert alert-info alert-dismissible" id="labelshow">
            <h4 class="nonnecta" id="nonnecta"><i class="icon fa fa-info"></i>YOU ARE APPLYING AS  NON NECTA STUDENTS</h4>
        </div>

     <?= $form->field($model, 'is_necta')->label(false)->hiddenInput(['value'=>22,'maxlength' => true,'id'=>"switch_right"]) ?>        
     <?php
      echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 2,
                        'id' => "nonnecta_block_id",
                        'attributes' => [
      'f4indexno_non_necta' => ['type' => Form::INPUT_TEXT, 'label' => 'F4 Index #', 'options' => ['placeholder' => 'Enter ']],
       'firstname' => ['type' => Form::INPUT_TEXT, 'label' => 'First Name', 'options' => ['placeholder' => 'Enter ']],
       'middlename' => ['type' => Form::INPUT_TEXT, 'label' => 'Middle Name', 'options' => ['placeholder' => 'Enter .']],
       'surname' => ['type' => Form::INPUT_TEXT, 'label' => 'Last Name', 'options' => ['placeholder' => 'Enter .']],
                        ]
                    ]);
      ?>
      <?php
      echo Form::widget([
          'model' => $model,
          'form' => $form,
          'columns' => 1,
          'id' => "nonnecta_block_completionyear_id",
          'attributes' => [
      'f4_completion_year_nonnecta' => ['type' => Form::INPUT_WIDGET,
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
        echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'create-button-id']
        );
        ActiveForm::end();
        ?>
        </div>
</div>
</div>
</div>




 
