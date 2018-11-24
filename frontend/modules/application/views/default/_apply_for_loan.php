<script>
    function setType(type) {
        //$('#create-button-id').attr('style', 'display: block');
        if (type == 'NECTA') {
            //Show
            $("#education-registration_number").attr('maxlength','10');
            $('#create-button-id').attr('style', 'display:none');
             $('.field-user-verifycode').attr('style', 'display:none');
            document.getElementById("myDiv").style.display = "none";
            $('#switch_right').val('1');
            $('#school_block_id').attr('style', 'display: block');
            //Hide
            $('#institution_block_id').attr('style', 'display: none');
            $('#contact_block_id').attr('style', 'display: none');
            $('#password_block_id').attr('style', 'display: none');
            $('#labelshow').attr('style', 'display: block');
            $('#necta').attr('style', 'display: block');
            $('#non-necta').attr('style', 'display: none');
            //#labelshow,
            $('#user-firstname').val('All');
            $('#user-middlename').val('All');
            $('#user-surname').val('All');
              $('#user-sex').val('M');
            $('#education-registration_number').val('');
            $('#education-completion_year').val('');
            $('#mickidadi12').attr('style', 'display:none');
            $('#mickidadi21').attr('style', 'display:none');
        }
        if (type == 'NONE-NECTA') {
            //Show
             $("#education-registration_number").attr('maxlength','16');
            document.getElementById("myDiv").style.display = "none";
             $('.field-user-verifycode').attr('style', 'display: block');
            $('#create-button-id').attr('style', 'display: block');
            $('#switch_right').val('2');
            $('#institution_block_id').attr('style', 'display: block');
            $('#password_block_id').attr('style', 'display: block');
            $('#contact_block_id').attr('style', 'display: block');
            $('#school_block_id').attr('style', 'display: block');
            $('#necta').attr('style', 'display: none');
            //Hide
            $('#labelshow').attr('style', 'display: block');
            $('#non-necta').attr('style', 'display: block');

            $('#mickidadi12').attr('style', 'display: block');
            $('#mickidadi21').attr('style', 'display: block');

            // document.getElementById("loader").style.display = "block";
            //#labelshow,
            $('#user-firstname').val('');
            $('#user-middlename').val('');
            $('#user-surname').val('');
            $('#user-sex').val('');
            $('#education-registration_number').val('');
            $('#education-completion_year').val('');
//                $.ajax({
//                type: 'post',
//                //dataType: 'json',
//                url: "<?= Yii::$app->getUrlManager()->createUrl('/application/default/none-necta'); ?>",
//                data: {status:1},
//                success: function (data) {
//                    //  alert(data);
//                    document.getElementById("loader").style.display = "none";
//                    $('#create-button-id').attr('style', 'display:block');
//                    document.getElementById("myDiv").style.display = "block";
//                    $('#myDiv').html(data);
//                }
//
//
//            });
        }
    }
    function check_necta() {
        var registrationId = document.getElementById('education-registration_number').value;
        var year = document.getElementById('education-completion_year').value;
        var status = document.getElementById('switch_right').value;
        //var status="Halima"; 
             if(status == 1){
          $('#create-button-id').attr('style', 'display: none');
            document.getElementById("password_block_id").style.display = "none";
            document.getElementById("contact_block_id").style.display = "none";
             }
            //document.getElementById("w5").style.display = "none";
     
        if (registrationId != "" && year != "" && status == 1) {
            document.getElementById("loader").style.display = "block";
            document.getElementById("myDiv").style.display = "none";
            document.getElementById("contact_block_id").style.display = "none";
             $('.field-user-verifycode').attr('style', 'display: none');
            
            $.ajax({
                type: 'post',
                //dataType: 'json',
                url: "<?= Yii::$app->getUrlManager()->createUrl('/application/default/necta'); ?>",
                data: {registrationId: registrationId, year: year},
                success: function (data) {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("myDiv").style.display = "block";
                    $('#myDiv').html(data);
                }
            });
        }
        return false;
    }
    function check_status() {
        // $('#checkboxId').is(':checked')
        if ($('#user-validated').is(':checked')) {
            //form-group field-user-verifycode
            $('#create-button-id').attr('style', 'display: block');
            $('.field-user-verifycode').attr('style', 'display: block');
           document.getElementById("contact_block_id").style.display = "block";
            document.getElementById("password_block_id").style.display = "block";
         

        } else {
            $('#create-button-id').attr('style', 'display: none');
            $('.field-user-verifycode').attr('style', 'display:none');
            document.getElementById("contact_block_id").style.display = "none";
            document.getElementById("password_block_id").style.display = "none";
            

        }
    }

</script>

<style>
    #myDiv,#contact_block_id,#password_block_id,#institution_block_id,#school_block_id,#mickidadi12,#mickidadi21,.field-user-verifycode {
        display: none;
        //text-align: center;
    }
</style>
<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\captcha\Captcha;
use backend\modules\application\models\ApplicationCycleStatus;
$yearmax = date("Y");
for ($y = 1982; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}

$test_start='+2559209310';
             if($test_start[0]!=0){
           echo $test_start[0]." mickidadi";
             }
?>

<div class="education-form">

    <?php
    $necta = '';
    $nonenecta = '';
    //$('').attr('style', 'display: block');
    if ($model->is_necta == 1 && $model->is_necta != NULL&&count($modelall->errors)>0) {
        $necta = "checked='checked'";
        echo '<style>
        #necta, #myDiv,#contact_block_id,#password_block_id,#school_block_id,.field-user-verifycode {
            display:block;
        }
          #non-necta{
            display: none;
        }
    </style>';
    } else if ($model->is_necta == 2 && $model->is_necta != NULL&&count($modelall->errors)>0) {
        $nonenecta = "checked='checked'";
        echo '<style>
           #non-necta,#myDiv,#contact_block_id,#password_block_id,#institution_block_id,#school_block_id,#mickidadi12,#mickidadi21,.field-user-verifycode {
            display:block;
        }
          #necta{
            display: none;
        }
    </style>';
    } else {
        echo '<style>
        #w1, #w2, #w3,#non-necta ,#necta,#labelshow,#create-button-id{
            display: none;
        }
    </style>';
    } ?>
      <div class="col-lg-12"><?php echo Html::a('<i class="glyphicon glyphicon-home"></i>Return Home', ['/application/default/home-page'], ['class' => '','style'=>'margin-top: -10px; margin-bottom: 15px;size:16px']);   ?>
       <?=$message?> <?= Html::a('<i class="glyphicon glyphicon-lock"></i>Login ', ['/application/default/home-page','activeTab'=>'login_tab_id'],['class'=>'pull-right','style'=>'margin-top: -10px; margin-bottom: 15px;size:16px']) ?>
        <div colspan="12"></div>
    </div>
    <br/><br/>
    <?php 
   //find allocation status
   //$model_application_status=ApplicationCycleStatus::find()->where(['application_cycle_status_id'=>2])->one();
   
    $sqlquest=Yii::$app->db->createCommand('SELECT count(*) FROM `application_cycle` apc join academic_year ac  on apc.`academic_year_id`=ac.`academic_year_id` WHERE application_cycle_status_out_id=2 AND ac.`academic_year_id`=1')->queryScalar();
    if($sqlquest==0){
        
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                'enableClientValidation' => TRUE,
                
    ]);
    ?>
  
    
    <div class="col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading">
    </div>
            <div class="panel-body">
                <p><b>NECTA STUDENTS </b>(For Applicants who did their form 4 Examinations in Tanzania / Kwa wanafunzi waliofanya mtihani wa kidato cha nne ndani ya nchi) </p>
                <center>  
                    <label class="radio-inline"><button type="button"  class="btn btn-block btn-primary btn-lg" name="Education[is_necta]" onclick="setType('NECTA')" value="1" <?php echo $necta; ?> >NECTA [Completed in Tanzania]</label>
                </center>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading">

            </div>
            <div class="panel-body">
                <p><b> NON NECTA STUDENTS </b>(For Applicants who did form 4 Examinations overseas / Kwa waombaji waliofanya mtihani wa kidato cha nne Nje ya nchi) </p>
                <center>
                    <label class="radio-inline"><button type="button" class="btn btn-block btn-warning btn-lg" name="Education[is_necta]" onclick="setType('NONE-NECTA')" value="2" <?php echo $nonenecta; ?> >NON - NECTA [Holders of Foreign Certificates]</label>
                </center>
            </div>
        </div>
    </div>
    <br>
    <div class="col-lg-12">

        <div class="alert alert-info alert-dismissible" id="labelshow">

            <h4 class="necta" id="necta"><i class="icon fa fa-info"></i>  YOU ARE  APPLYING AS  NECTA  STUDENTS</h4>
            <h4 class="non-necta" id="non-necta"><i class="icon fa fa-info"></i>YOU ARE APPLYING AS  NON NECTA STUDENTS</h4>
        </div>
        
     <?= $form->field($model, 'is_necta')->label(false)->hiddenInput(['maxlength' => true,'id'=>"switch_right"]) ?>

        <?php
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'id' => "institution_block_id",
            'columns' => 2,
            'attributes' => [
                'institution_name' => ['label' => 'O-Level School Name', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter O-level School Name', 'maxlength' => 50]],
                'country_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => yii\helpers\ArrayHelper::map(\frontend\modules\application\models\Country::find()->all(), 'country_id', 'country_name'), 'options' => ['prompt' => '--COUNTRY OF STUDY--']],
            ]
        ]);
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'id' => "school_block_id",
            'columns' => 2,
            'attributes' => [
                'registration_number' => ['type' => Form::INPUT_TEXT, 'label' => 'F4 Index #', 
              
         'options' => ['maxlength'=>10,'placeholder' => '', 'onchange' => 'check_necta()','data-toggle' => 'tooltip',
            'data-placement' =>'top','title' => '']],
                'completion_year' => ['type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\select2\Select2::className(),
                    'label' => 'Completion Year',
                    'options' => [
                        'data' => $year,
                        'options' => [
                            'prompt' => 'Select Completion Year',
                            'onchange' => 'check_necta()'
                        //'id'=>'entry_year_id'
                        ],
                    ],
                ],
            //'completion_year' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg. 2001']],
            ]
        ]);
        
        echo "<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center><div style='display:none;' id='myDiv' class='animate-bottom'></div>";
//echo Form::widget([
//    'model' => $model,
//    'form' => $form,
//    'columns' => 2,
//    'attributes' => [
//        'division' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Division']],
//        'points' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Points']],
//    ]
//]);

        echo Form::widget([
            'model' => $modelall,
            'form' => $form,
            'columns' => 2,
            'id' => "mickidadi12",
            'attributes' => [
                'firstname' => ['type' => Form::INPUT_TEXT, 'label' => 'First Name', 'options' => ['placeholder' => 'Enter ']],
                'middlename' => ['type' => Form::INPUT_TEXT, 'label' => 'Middle Name', 'options' => ['placeholder' => 'Enter .']],
            ]
        ]);
        echo Form::widget([
            'model' => $modelall,
            'form' => $form,
            'columns' => 2,
            'id' => "mickidadi21",
            'attributes' => [
                'surname' => ['type' => Form::INPUT_TEXT, 'label' => 'Last Name', 'options' => ['placeholder' => 'Enter ']],
                'sex' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'items' => ['M' => 'Male', 'F' => 'Female'],
                     'options' => [
                        'prompt' => 'Select Gender',
                         
                    ],
                ],
            ]
        ]);
        echo Form::widget([
            'model' => $modelall,
            'form' => $form,
            'id' => "contact_block_id",
            'columns' => 2,
            'attributes' => [
              
                'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['maxlength'=>10,'placeholder' => '0*********','data-toggle' => 'tooltip',
                'data-placement' => 'top', 'title' => 'Phone Number eg 07XXXXXXXX or 06XXXXXXXX or 0XXXXXXXXX']],
                'email_address' => ['enableAjaxValidation' => true, 'validateOnChange' =>true,'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Your Email ']],
            ]
        ]);
        echo Form::widget([
            'model' => $modelall,
            'form' => $form,
            'id' => "password_block_id",
            'columns' => 2,
            'attributes' => [
                'password' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => '','data-toggle' => 'tooltip',
                'data-placement' => 'top', 'title' => 'Password must contain at least one lower and upper case character and a digit.']],
                'confirm_password' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => '','data-toggle' => 'tooltip',
                'data-placement' => 'top', 'title' => 'Password must contain at least one lower and upper case character and a digit.']],
            ]
        ]);
      ?>
        <?= $form->field($modelall, 'verifyCode')->widget(Captcha::className(), [
                    'captchaAction'=>'/site/captcha','id'=>'captcha_block_id'
                ]) ?>
 
        <?php
        echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'create-button-id']
        );
        ActiveForm::end();
         //  print_r($modelall->errors);
       // 'template' => '<div class="row"><div class="col-lg-9">{image}</div><div class="col-lg-6">{input}</div></div>',
       //print_r($modelall->errors);
           //   echo substr('', 1)
        }else{ ?>
   <div class="alert alert-warning alert-dismissible">
               
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                <h2>The Application is Currently Closed.</h2>
              </div>	
	<?php }?>
    </div>
</div>