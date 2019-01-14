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
<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'options' => ['enctype' => 'multipart/form-data'],
            'enableClientValidation' => TRUE,]);
?>
<?php
echo $form->errorSummary($model);
?>
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
                        <?= $form->field($model, 'category')->label(Module)->dropDownList(Yii::$app->params['report_modules'], ['prompt' => 'Select']) ?>
                        <?php //var_dump(Yii::$app()->params['report_modules']);   ?>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>
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
                        <?php
                        if(!$model->isNewRecord){
                          echo "Template: " .$model->file_name; 
                        }
                        /*
                          echo $form->field($model, 'file_name')->widget(FileInput::classname(), [
                          //'options' => ['accept' => 'verification/pdf'],
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
                         */
                        //echo $model->imageDisplay;

                        if (empty($model->file_name) || $model->file_name == '') {
                            echo $form->field($model, 'file_name')->widget(FileInput::classname(), [
                                'options' => ['accept' => '.php'],
                                'pluginOptions' => [
                                    'showUpload' => false,
                                ],
                            ]);
                        } else {
                            echo Html::a(
                                    Yii::t('app', 'Remove Report Template File'), Url::to(['/report/report/delete-image', 'id' => $model->id]), ['class' => 'btn btn-danger']
                            );
                        }
                        ?>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label"></label>
                    <div class="col-lg-9">
                        <?= $form->field($model, 'package')->label(Narration)->textarea(['rows' => '6']) ?>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-lg-3 control-label"></label>
                    <div class="col-lg-9">
						<?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout        
                                    'student_printview' => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' =>'Show in Student Printing',
                                        'options' => [
                                            'data' => ['0' => 'No', '1' => 'Yes'],
                                            'options' => [
                                                'prompt' => 'Select',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
									'printing_mode' => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' =>'PDF Printing Mode',
                                        'options' => [
                                            'data' => ['0' => 'Normal', '1' => 'Template'],
                                            'options' => [
                                                'prompt' => 'Select',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                    'excel_printing_mode' => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' =>'Excel Printing Mode',
                                        'options' => [
                                            'data' => ['0' => 'Normal', '1' => 'Template'],
                                            'options' => [
                                                'prompt' => 'Select',
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
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
                    <label class="col-lg-12 control-label">Main SQL</label>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'sql')->label(false)->textarea(['rows' => '6']) ?>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>               

                <div class="form-group">
                    <label class="col-lg-12 control-label">Main SQL where</label>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'sql_where')->label(false)->textarea(['rows' => '3']) ?>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-12 control-label">Main SQL group By</label>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'sql_group')->label(false)->textarea(['rows' => '2']) ?>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-12 control-label">Main SQL Order By</label>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'sql_order')->label(false)->textarea(['rows' => '2']) ?>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-lg-12 control-label">Sub-Query SQL</label>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'sql_subquery')->label(false)->textarea(['rows' => '6']) ?>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12 control-label">Sub-Query where</label>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'sql_subquery_where')->label(false)->textarea(['rows' => '3']) ?>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12 control-label">Sub-Query group by</label>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'sql_subquery_group')->label(false)->textarea(['rows' => '2']) ?>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-12 control-label">Sub-Query Order by</label>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'sql_subquery_order')->label(false)->textarea(['rows' => '2']) ?>
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
                    <th colspan="6" style="text-align:center;">Form Search Fields</th>                    
                </tr>
                <tr class="text-uppercase">
                    <th width="15%">Form Label</th>
                    <th width="20%">Form Field Type</th>
                    <th width="15%">Field Data Type</th>                    
                    <th width="15%">Description</th>
                    <th width="20%">Column</th>
                    <th width="15%">Condition</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $results = \backend\modules\report\models\ReportFilterSetting::find()
                        ->select('number_of_rows')
                        ->where(['is_active' => '1'])
                        ->orderBy(['report_filter_setting_id' => SORT_DESC])
                        ->one();
                $number_of_rows = $results->number_of_rows;
                for ($i = 1; $i <= $number_of_rows; $i++) {
                    ?>
                    <tr>
                        <td>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'field' . $i)->label(false)->textInput(['maxlength' => true]) ?>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php
                            echo Form::widget([// fields with labels
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'type' . $i => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => \backend\modules\report\models\Report::getOperatorsType(),
                                            'options' => [
                                                'prompt' => '-- Select --',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                            ]]);
                            ?>
                        </td>
                        <td>
                            <?php
                            echo Form::widget([// fields with labels
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'field_data_type' . $i => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => \backend\modules\report\models\Report::getFieldDataType(),
                                            'options' => [
                                                'prompt' => '-- Select --',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                            ]]);
                            ?>
                        </td>

                        <td>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'description' . $i)->label(false)->textInput(['maxlength' => true]) ?>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>

                        </td>
                        <td>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'column' . $i)->label(false)->textInput(['maxlength' => true]) ?>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>

                        </td>
                        <td>
                            <?php
                            echo Form::widget([// fields with labels
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'condition' . $i => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => \backend\modules\report\models\Report::getOperatorsCondition(),
                                            'options' => [
                                                'prompt' => '-- Select --',
                                            ],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                            ]]);
                            ?>
                        </td>
                    </tr>
                <?php } ?>

                <tr class="bg-indigo">
                    <td colspan="6"></td>
                </tr>
            </tbody>
        </table>
        <div class="text-right">
            <?= Html::submitButton($model->isNewRecord ? 'Register' : 'Save Changes', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            <?php
            echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
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




        $(".checker").click(function () {
            if (this.checked == true)
            {
                var package = [];
                $.each($("input[name='packageCode[]']:checked"), function () {
                    package.push($(this).val());
                    //alert("Selected Packages are : " + package.join(", "));
                    document.getElementById("Report_package").value = package.join(", ");
                });


            } else {
                var package = [];
                $.each($("input[name='packageCode[]']:checked"), function () {
                    package.push($(this).val());
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
