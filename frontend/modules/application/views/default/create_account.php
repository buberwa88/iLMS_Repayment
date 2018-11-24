<script>
    function displayHintText(id){
        return false; //Currently this function has been disabled
        var content = $('#'+id+'_hint_content').html();
    
        $('#help_text_div_id').html(content);
    }
</script>

<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

?>




<div class="row">
<!--  <div class="col-xs-6">-->

    <?php
 $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
 
   echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [

            'firstname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'FirstName','onfocus'=>'displayHintText("firstname")','id'=>'firstname']],
            //'middlename' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'MiddleName','onfocus'=>'displayHintText("middlename")','id'=>'middlename']],
            
            'surname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Surname','onfocus'=>'displayHintText("surname")','id'=>'surname']],
           
                     
            
]]);
echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [

            'email_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Valid Email Address','onfocus'=>'displayHintText("email_address")']],
            'confirm_email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Confirm your Email Address','onfocus'=>'displayHintText("confirm_email")']],
            
            'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg. +255 714 872 615','onfocus'=>'displayHintText("telephone_no")','maxlength'=>13]],
            'confirm_telephone_no' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg. +255 714 872 615','onfocus'=>'displayHintText("confirm_telephone_no")','maxlength'=>13]],
            
            'password' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => 'Password ','onfocus'=>'displayHintText("password")']],
            'confirm_password' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => 'Repeat Password','onfocus'=>'displayHintText("confirm_password")']],
            

            

            
            
]]);
  
  
//   echo Form::widget([
//
//        'model' => $model,
//        'form' => $form,
//        'columns' => 2,
//        'attributes' => [
//
//            'captcha' => ['type' => Form::INPUT_WIDGET, 'widgetClass'=> yii\captcha\Captcha::className(),'label'=>'Type below the blue characters. Click on the blue characters to get a new one if not clearly seen'],
//            
//            
//]]);
    
    echo '<center>'.Html::submitButton(Yii::t('app', 'Click Here to Register'), ['class' => 'btn btn-success btn-sm  pagination-centered' ]).'</center>';
    ActiveForm::end();
    ?></div>
<!--    <div class="col-xs-6" id="help_text_div_id" style="padding-top: 20px;">

        
    </div>-->
    
   
<!--</div>-->

<!-- Hint Text... -->

<div id="payment_code_hint_content" style="display: none">
    <strong>Payment Code</strong> <br>
    Payment Code Help text here...
</div>

<div id="oindexno_hint_content" style="display: none">
    
    <strong>"O"-Level Index Number</strong> <br>
        Is your index number that you used during your form 
        four education. If you have multiple sittings, please use the index number  
        of your first sitting. The index number should be concatnated by completion year. 

</div>

<div id="aindexno_hint_content" style="display: none">
    <strong>"A" Level Index number</strong> <br>
    A Level index number Help text here...
</div>

<div id="email_address_hint_content" style="display: none">
    <strong>Email Address</strong> <br>
    Email Address Help text here...
</div>

<div id="confirm_email_hint_content" style="display: none">
    <strong>Confirm email address</strong> <br>
    Confirm email address Help text here...
</div>

<div id="password_hint_content" style="display: none">
    <strong>Password</strong> <br>
    Password Help text here...
</div>

<div id="confirm_password_hint_content" style="display: none">
    <strong>Confirm Password</strong> <br>
    Confirm Password Help text here...
</div>


<div id="firstname_hint_content" style="display: none">
    <strong>Enter your firstname</strong> <br>
    Please enter your Firstname 
</div>

<div id="middlename_hint_content" style="display: none">
    <strong>Enter your middlename</strong> <br>
    Please enter your Middlename 
</div>


<div id="surname_hint_content" style="display: none">
    <strong>Enter your Surname</strong> <br>
    Please enter your Surname 
</div>



<div id="telephone_no_hint_content" style="display: none">
    <strong>Enter your Telephone Number</strong> <br>
   This number must be correct as we may use it to contact you when needed
</div>

<div id="confirm_telephone_no_hint_content" style="display: none">
    <strong>Repeat your Telephone</strong> <br>
   Repeat the telephone number
</div>





