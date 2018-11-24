<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementBatch */
/* @var $form yii\widgets\ActiveForm */
 
?>
 
 <script type="text/javascript">

 /********************  
  * Id can be hide or show
  * 
	*onload functions
	********************/
	window.onload = start;
	function start () {
		//alert("mickidadi");
		body();
		 
	}
     function body() { 
   var cat= document.getElementById('employerId').style.display = 'none';
   var cat= document.getElementById('additionVersionId').style.display = 'none';
   var cat1= document.getElementById('countryId').style.display = 'none';
   var cat3= document.getElementById('disburseTypeId').style.display = 'none';
   var cat4= document.getElementById('InstitutionId').style.display = 'none';
   var cat5= document.getElementById('paylistId').style.display = 'none';
    var cat1= document.getElementById('loaderId').style.display = 'none';
   //disbursementbatch-disburse
     updateStatus();
        }
    function updateStatus(){
       
          var category= document.getElementById('disbursementbatch-applicant_category').value;
             if(category==1){
             var cat1= document.getElementById('countryId').style.display = 'none';         
                  }
                else if(category==2){
          var cat1= document.getElementById('countryId').style.display = '';          
                }
          var level= document.getElementById('disbursementbatch-level').value;
             if(level==2){
             var cat1= document.getElementById('InstitutionId').style.display = 'none'; 
              var cat= document.getElementById('employerId').style.display = '';
                  }
                else if(level==1){
          var cat1= document.getElementById('InstitutionId').style.display = ''; 
           var cat= document.getElementById('employerId').style.display = 'none';
                }
          
             var typevalue= document.getElementById('disbursementbatch-instalment_type').value;
             if(typevalue==1){
             var cat1= document.getElementById('additionVersionId').style.display = 'none';         
                  }
                else if(typevalue>1){
          var cat1= document.getElementById('additionVersionId').style.display = '';          
                }
          var paylist= document.getElementById('disbursementbatch-disburse').value;
             if(paylist==1){
             var cat1= document.getElementById('paylistId').style.display = 'none';         
                  }
                else if(paylist>1){
          var cat1= document.getElementById('paylistId').style.display = '';          
                }       
    }
  
</script>
<style>
div.disabled {
display: none;
}
</style>
<?php
//echo Yii::$app->getUrlManager()->createUrl('/disbursement/disbursement-batch/create');
$this->registerJs( "
        $('body').on('beforeSubmit', 'form#myform', function () {
             var form = $(this);
            
//                        var property = document.getElementById('disbursementbatch-file').files[0];
//                        var image_name = property.name;
//                                 
//                        var image_extension = image_name.split('.').pop().toLowerCase();
//
////                        if(jQuery.inArray(image_extension,['gif','jpg','jpeg','']) == -1){
////                          alert('Invalid image file');
////                        }
                        var formData = new FormData(this);
                        //formData.append('file',property);
                       
             // return false if form still have some validation errors
             if (form.find('.has-error').length) {
                  return false;
             }
            document.getElementById('loaderId').style.display = '';
            document.getElementById('formId').style.display = 'none';
          // alert(form.attr('action'));
             // submit form
               $.ajax({
                            type   : 'post',
                            //dataType: 'json',
                            url: form.attr('action'),
                            data:formData,
                                processData: false,
                                contentType: false,
                            success: function (data) {
                               alert(data);
                          document.getElementById('formId').style.display = '';
                          document.getElementById('loaderId').style.display = 'none';
                           //  $('#displaysummary').html(data);
                            }
                          

                             }) ;
             return false;
        }); ");
?>
<div class="disbursement-batch-form" id="formId">
  
    <?php $form = ActiveForm::begin(['id' => 'myform','options' => ['enctype' => 'multipart/form-data']]); ?>
      <div class="profile-user-info profile-user-info-striped">
              <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Loanee Category:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
    <?= $form->field($model, 'applicant_category')->label(false)->dropDownList(
                                 [1=>"Local",2=>"OverSee"],
                                [
                                'prompt'=>'Select Loanee Category',
                                'onchange'=>'updateStatus()'
                                ]
                              ) ?>
                          </div>
                </div>
            </div>
             <div class="profile-info-row" id="countryId">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Country:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
    <?= $form->field($model, 'country')->label(false)->dropDownList(
                                 [1=>"USA",2=>"Kenya",3=>"UK"],
                                [
                                'prompt'=>'Select Country',
                                ]
                              ) ?>
                          </div>
                </div>
            </div>
              <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Study Level:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
    <?= $form->field($model, 'level')->label(false)->dropDownList(
                                ArrayHelper::map(backend\modules\application\models\ApplicantCategory::find()->all(),'applicant_category_id','applicant_category'),
                                [
                                'prompt'=>'Select Study Level',
                                'onchange'=>'updateStatus()'
                                ]
                              ) ?>
                          </div>
                </div>
            </div>
            <div class="profile-info-row" id="employerId">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Employer:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
    <?= $form->field($model, 'employer_id')->label(false)->dropDownList(
                                [1=>"UDSM",2=>"DUSE",3=>"UDOM"],
                                [
                                'prompt'=>'Select Employer',
                                ]
                              ) ?>
                          </div>
                </div>
            </div>
              <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Disburse Options:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
    <?= $form->field($model, 'disburse')->label(false)->dropDownList(
                                [1=>"All",2=>"Selective"],
                                [
                                'prompt'=>'Select Disburse Options',
                                'onchange'=>'updateStatus()'
                                ]
                              ) ?>
                          </div>
                </div>
            </div>
                <div class="profile-info-row" id="disburseTypeId">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Disburse Type:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
    <?= $form->field($model, 'disburse_type')->label(false)->dropDownList(
                                [1=>"Part",2=>"Lumpsum"],
                                [
                                'prompt'=>'Select Disburse Type',
                                ]
                              ) ?>
                          </div>
                </div>
            </div>
        <div class="profile-info-row" id="InstitutionId">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Institution:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
    <?= $form->field($model, 'learning_institution_id')->label(false)->dropDownList(
                           ArrayHelper::map(backend\modules\application\models\LearningInstitution::find()->where(["institution_type"=>"UNIVERSITY"])->all(),'learning_institution_id','institution_name'),
                                [
                                'prompt'=>'Select Institution',
                                ]
                              ) ?>
                     </div>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Academic Year:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
   <?= $form->field($model, 'academic_year_id')->label(false)->dropDownList(
                           ArrayHelper::map(\common\models\AcademicYear::find()->all(),'academic_year_id','academic_year'),
                                [
                                'prompt'=>'Select Academic Year',
                                ]
                              ) ?>
                      </div>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Financial Year:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
   <?= $form->field($model, 'financial_year_id')->label(false)->dropDownList(
                           ArrayHelper::map(\backend\modules\disbursement\models\FinancialYear::find()->all(),'financial_year_id','financial_year'),
                                [
                                'prompt'=>'Select Financial Year',
                                ]
                              ) ?>
                      </div>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Instalment :</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
   <?= $form->field($model, 'instalment_definition_id')->label(false)->dropDownList(
                           ArrayHelper::map(\backend\modules\disbursement\models\InstalmentDefinition::findAll(["is_active"=>1]),'instalment_definition_id','instalment'),
                                [
                                'prompt'=>'Select Instalment',
                                ]
                              ) ?>
                     </div>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Loan Item:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
      <?= $form->field($model, 'loan_item_id')->label(false)->dropDownList(
                           ArrayHelper::map(backend\modules\allocation\models\LoanItem::findAll(["is_active"=>1]),'loan_item_id','item_name'),
                                [
                                'prompt'=>'Select Loan Item',
                                ]
                              ) ?>
                      </div>
                </div>
            </div>
                <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Loan Category:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
    <?= $form->field($model, 'disbursed_as')->label(false)->dropDownList(
                                [1=>"Loan",2=>"Grant"],
                                [
                                'prompt'=>'Select Loan Category',
                                ]
                              ) ?>
                          </div>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Type :</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
       <?= $form->field($model, 'instalment_type')->label(false)->dropDownList(
                                 [1=>"Normal",2=>"Additional"],
                                [
                                'prompt'=>'Select Instalment Type',
                                'onchange'=>'updateStatus()'
                                ]
                              ) ?>
           </div>
                </div>
            </div>
            <div class="profile-info-row" id="additionVersionId">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Additional Version:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
       <?= $form->field($model, 'version')->label(false)->dropDownList(
                                [1=>"1",2=>"2",3=>"3",4=>"4",5=>"5",6=>"6"],
                                [
                                'prompt'=>'Select Additional Version',
                                ]
                              ) ?>
           </div>
                </div>
            </div>
              <div class="profile-info-row" id="paylistId">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Select Pay List:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
    <?= $form->field($model, 'file')->label(false)->fileInput(['maxlength' => true]) ?>
        </div>
                </div>
            </div>
           <div class="profile-info-row">
                <div class="profile-info-name">
                    <label class="control-label" for="email">Description:</label>
                </div>
                <div class="profile-info-value">
                    <div class="col-sm-12">
    <?= $form->field($model, 'batch_desc')->label(false)->textInput(['maxlength' => true]) ?>
 
    <?= $form->field($model, 'created_at')->label(false)->hiddenInput(["value"=>date("Y-m-d")]) ?>
    <?= $form->field($model, 'created_by')->label(false)->hiddenInput(["value"=>\yii::$app->user->identity->user_id]) ?>
       </div>
                </div>
            </div>
        </div>
        <div class="space10"></div>
        <div class="col-sm-12">
            <div class="form-group button-wrapper">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
<?php ActiveForm::end(); ?>

    </div>
<div id="loaderId" style="display:none">
 
  <?php echo Html::img('@web/image/loader/loader2.gif') ?>  
</div>

<div class="space10"></div>