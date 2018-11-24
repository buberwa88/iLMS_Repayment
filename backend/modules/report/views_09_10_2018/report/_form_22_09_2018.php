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

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\Report */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,]); ?>

<div class="row">
<div class="col-md-6">

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"></h5>
            <div class="heading-elements">
                <!-- <ul class="icons-list">
                     <li><a data-action="collapse"></a></li>
                     <li><a data-action="reload"></a></li>
                     <li><a data-action="close"></a></li>
                 </ul>-->
            </div>

        </div>
    <div class="panel-body">
        <div class="form-group">
           <label class="col-lg-3 control-label"></label>
            <div class="col-lg-9">
                <?= $form->field($model, 'name')->label(Name)->textInput(['maxlength' => true]) ?>
                <span class="help-block text-danger"></span>
            </div>
        </div>



        <div class="form-group">
           <label class="col-lg-3 control-label"></label>
            <div class="col-lg-9">
                <?= $form->field($model, 'category')->label(Category)->dropDownList([ '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', ], ['prompt' => 'Select']) ?>
                <span class="help-block text-danger"></span>
            </div>
        </div>


        <div class="form-group">
           <label class="col-lg-3 control-label"></label>
            <div class="col-lg-9">                
                <?php
 echo $form->field($model, 'file_name')->widget(FileInput::classname(), [
    'options' => ['accept' => 'verification/pdf'],
        'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => TRUE,
        'showUpload' => false,
       // 'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Report Template (required format .php only)',
         'initialPreview'=>[
            "$model->file_name",
           
        ],
        'initialCaption'=>$model->file_name,
        'initialPreviewAsData'=>true,
    ]
]);
 ?>
                <span class="help-block text-danger"></span>
            </div>
        </div>
        
        <div class="form-group">
           <label class="col-lg-3 control-label"></label>
            <div class="col-lg-9">
                <?= $form->field($model, 'package')->label(Package)->textarea(['rows' => '6']) ?>
                <span class="help-block text-danger"></span>
            </div>
        </div>
</div>
</div>
</div>

<div class="col-md-6">
    <div class="panel panel-flat">
        <div class="panel-heading"></div>
        <div class="panel-body">


            <div class="form-group">
                <label class="col-lg-12 control-label">SQL</label>
                <div class="col-lg-12">
                    <?= $form->field($model, 'sql')->label(false)->textarea(['rows' => '6']) ?>
                    <span class="help-block text-danger"></span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-12 control-label">SQL where</label>
                <div class="col-lg-12">
                    <?= $form->field($model, 'sql_where')->label(false)->textarea(['rows' => '3']) ?>
                    <span class="help-block text-danger"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-12 control-label">SQL group</label>
                <div class="col-lg-12">
                    <?= $form->field($model, 'sql_group')->label(false)->textarea(['rows' => '2']) ?>
                    <span class="help-block text-danger"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-12 control-label">SQL Order</label>
                <div class="col-lg-12">
                    <?= $form->field($model, 'sql_order')->label(false)->textarea(['rows' => '2']) ?>
                    <span class="help-block text-danger"></span>
                </div>
            </div>



        </div>
    </div>
</div>
</div>


    <div class="panel panel-flat">
        <div class="panel-heading"></div>
        <div class="panel-body">

            <table class="table table-condensed table-hover table-striped table-bordered">
                <thead class="bg-indigo">
                <tr class="text-uppercase">
                    <th width="20%">Parameter</th>
                    <th width="20%">Type</th>
                    <th width="20%">Description</th>
                    <th width="20%">Column</th>
                    <th width="20%">Condition</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i=1; $i<=5; $i++){ ?>
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <?= $form->field($model, 'field'.$i)->label(false)->textInput(['maxlength' => true]) ?>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <?= $form->field($model, 'type'.$i)->label(false)->textInput(['maxlength' => true]) ?>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                    </td>
                    <td>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <?= $form->field($model, 'description'.$i)->label(false)->textInput(['maxlength' => true]) ?>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>

                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <?= $form->field($model, 'column'.$i)->label(false)->textInput(['maxlength' => true]) ?>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>

                    </td>
                    <td>
                        <div class="form-group">
                              <div class="col-lg-12">
                                <?= $form->field($model, 'condition'.$i)->label(false)->textInput(['maxlength' => true]) ?>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php } ?>

                <tr class="bg-indigo">
                    <td colspan="5"></td>
                </tr>
                </tbody>
            </table>
<div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Register' : 'Save Changes', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);
?>
    </div>            
        </div>
    </div>

<script>
   /* function addText(event) {
        var targ = event.target || event.srcElement;
        document.getElementById("alltext").value += targ.textContent || targ.innerText;
    }*/
    $(document).ready(function () {




        $(".checker").click( function () {
            if(this.checked == true)
            {
                var package = [];
                $. each($("input[name='packageCode[]']:checked"), function(){
                    package. push($(this). val());
                    //alert("Selected Packages are : " + package.join(", "));
                    document.getElementById("Report_package").value = package.join(", ");
                });


            }else{
                var package = [];
                $. each($("input[name='packageCode[]']:checked"), function(){
                    package. push($(this). val());
                    //alert("Selected Packages are : " + package.join(", "));
                    document.getElementById("Report_package").value = package.join(", ");
                });

                document.getElementById("Report_package").value = package.join(", ");
            }
        });
    });
    function updater(tag)
    {
     /*else{
                $(".checker'.$modules->code.'").find("span").addClass("checked");
                $(".check'.$modules->code.'").prop("checked", true);
                $(".checkALL'.$modules->code.'").find("span").addClass("checked");

                var checked = true;

                $(this).parents(".module'.$modules->code.'")
                    .find("input[type=checkbox]")
                    .prop("checked", checked);
                alert(false);

            }

        });*/
    }
</script>
<?php ActiveForm::end(); ?>
