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
<script>
    function setRefundType2(type) {
        //alert(type);
        if (type == 'NECTA') {
            document.getElementById("general").style.display = "block";
            document.getElementById("necta").style.display = "block";
            document.getElementById("nonnecta").style.display = "none";
            $("#school_block_id").attr('maxlength','16');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_id').attr('style', 'display:none');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:none');
			$("#refundclaimant-f4indexno").attr('maxlength','10');
        }else if (type == 'NONNECTA') {
            document.getElementById("general").style.display = "block";
            document.getElementById("necta").style.display = "none";
            document.getElementById("nonnecta").style.display = "block";
			$("#refundclaimant-f4indexno").attr('maxlength','16');
            $('#nonnecta_block_id').attr('style', 'display:block');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:block');
        }
    }
</script>

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
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <p><b>NECTA STUDENTS </b>(For Claimants who did their form 4 Examinations in Tanzania) </p>
                        <center>
                            <label class="radio-inline"><button type="button"  class="btn btn-block btn-primary btn-lg" name="Education[is_necta]" onclick="setRefundType2('NECTA')" value="1" >NECTA[Completed in Tanzania]</label>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                        <center>
                            <p><b> NON NECTA STUDENTS </b>(For Claimants who did form 4 Examinations overseas) </p>
                            <label class="radio-inline"><button type="button" class="btn btn-block btn-warning btn-lg" name="Education[is_necta]" onclick="setRefundType2('NONNECTA')" value="2" >NON - NECTA [Holders of Foreign Certificates]</label>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div style='display:none;' id="general">
                    <?php
                    $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_VERTICAL,
                    'enableClientValidation' => TRUE,

                    ]);
                    ?>
               <div class="alert alert-info alert-dismissible" id="labelshow">

            <h4 class="necta" id="necta"><i class="icon fa fa-info"></i>  YOU ARE  APPLYING AS  NECTA  STUDENTS</h4>
            <h4 class="nonnecta" id="nonnecta"><i class="icon fa fa-info"></i>YOU ARE APPLYING AS  NON NECTA STUDENTS</h4>
        </div>

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
     
        <?php
        echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'create-button-id']
        );
        ActiveForm::end();
        ?>
        </div>
        </div>
</div>
</div>
</div>




 
