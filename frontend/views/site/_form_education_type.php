<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\captcha\Captcha;
use kartik\widgets\FileInput;
$list = [1 => 'NECTA STUDENTS [Completed in Tanzania]', 2 => 'NON NECTA STUDENTS [Holders of Foreign Certificates]'];
$yearmax = date("Y");
for ($y = 1982; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
?>
<script>
    function setRefundf4ed(type) {
        //alert(type);
        var educationCatV=$('#f4type_id input:checked').val();
        if (educationCatV == 1) {
            document.getElementById("general").style.display = "block";
            document.getElementById("necta").style.display = "block";
            document.getElementById("nonnecta").style.display = "none";
            document.getElementById("f4certificateDoc").style.display = "none";
            $("#school_block_id").attr('maxlength','16');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_id').attr('style', 'display:none');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:none');
			$("#refundclaimant-f4indexno").attr('maxlength','10');
        }else if (educationCatV == 2) {
            document.getElementById("general").style.display = "block";
            document.getElementById("necta").style.display = "none";
            document.getElementById("nonnecta").style.display = "block";
            document.getElementById("f4certificateDoc").style.display = "block";
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
            <div class="col-lg-12">
                    <?php
                    $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_VERTICAL,
                    'options' => ['enctype' => 'multipart/form-data'],
                    'enableClientValidation' => TRUE,
                    ]);
                    ?>
                    <?php
                    echo $form->field($model, 'f4type')->label('SELECT YOUR F4 CATEGORY')->radioList($list,
                        [
                            'inline'=>true,
                            'id'=>f4type_id,
                            'onchange'=>'setRefundf4ed(this)',
                        ]);
                    ?>

                <div style='display:none;' id="general">
               <div class="alert alert-info alert-dismissible" id="labelshow">

            <h4 class="necta" id="necta"><i class="icon fa fa-info"></i>  YOU ARE  APPLYING AS  NECTA  STUDENTS</h4>
            <h4 class="nonnecta" id="nonnecta">
                <i class="icon fa fa-info"></i>YOU ARE APPLYING AS  NON NECTA STUDENTS</h4>
        </div>
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
       'firstname' => ['type' => Form::INPUT_TEXT, 'label' => 'First Name', 'options' => ['placeholder' => 'Enter ']],
       'middlename' => ['type' => Form::INPUT_TEXT, 'label' => 'Middle Name', 'options' => ['placeholder' => 'Enter .']],
       'surname' => ['type' => Form::INPUT_TEXT, 'label' => 'Last Name', 'options' => ['placeholder' => 'Enter .']],
                        ]
                    ]);
      ?>
                    <div style='display:none;' id="f4certificateDoc">
                    <?php
                    echo $form->field($model, 'f4_certificate_document')->label('F4 Certificate Document:')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'site/pdf'],
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => TRUE,
                            'showUpload' => false,
                            // 'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                            'browseLabel' =>  'Certificate Document (required format .pdf only)',
                            'initialPreview'=>[
                                "$model->f4_certificate_document",

                            ],
                            'initialCaption'=>$model->f4_certificate_document,
                            'initialPreviewAsData'=>true,
                        ],

                    ])->hint('Attach the Certificate Document Having the Same Information as Provided Above');
                    ?>
                    </div>

                    <div class="text-right">
                        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                        <?php
                        echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
                        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['site/list-steps-nonbeneficiary','id'=>$refundClaimantid], ['class' => 'btn btn-warning']);

                        ActiveForm::end();
                        ?>
                    </div>
        </div>
        </div>
</div>
</div>
</div>




 
