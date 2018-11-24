<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
$fr = 'field';

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\Report */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'enableClientValidation' => TRUE,'action' => ['print-report'],'options' => ['method' => 'post']]); ?>

<div class="row">
<div class="col-md-6">

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"></h5>
            <div class="heading-elements">
                <h5 class="panel-title">REPORTS LIST</h5>
            </div>

        </div>
    <div class="panel-body">        
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
    ]); ?>
</div>
</div>
</div>

<div class="col-md-6">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">GENERATE REPORT</h5><br/>
        </div>
        <div class="panel-body">
            <center><h5 class="panel-title"><strong><?php echo strtoupper( $model->name." Report "); ?></strong></h5></center><br/>
             <?= $form->field($model, 'uniqid')->label(false)->hiddenInput(['value'=>$model->id,'readOnly'=>'readOnly']) ?>
            <?= $form->field($model, 'pageIdentify')->label(false)->hiddenInput(['value'=>'1','readOnly'=>'readOnly']) ?>
                <?php
                $results= \backend\modules\report\models\ReportFilterSetting::find()
                        ->select('number_of_rows')
                        ->where(['is_active'=>'1'])
                        ->orderBy(['report_filter_setting_id' => SORT_DESC])
                        ->one();
                //$number_of_rows=$results->number_of_rows;
				$number_of_rows=15;
                $model = \backend\modules\report\models\Report::findOne($model->id);
                for ($i = 1; $i <= $number_of_rows; $i++) {
                    $field = $fr . $i;
                    $description = 'description' . $i;
                    $type = 'type' . $i;
                    $type = $model->$type;
                    if (!empty($model->$field)) {
                        $name = 'input' . $i;
                        $value = '';
                        if (!empty($_POST[$name]))
                            $value = $_POST[$name];

                        if ($type == 'text') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
				            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                                            <?= $form->field($model, $name)->label(false)->textInput(['value'=>$value,'maxlength' => true]) ?>
                            <?php
				            echo "</div></div>";
                        }
                        if ($type == 'date') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
                            ?>                          
                            
                            <?= $form->field($model, $name)->label(false)->widget(DatePicker::classname(), [
           'name' => $name,                                
    'options' => ['placeholder' => 'yyyy-mm-dd',
                  'todayHighlight' => false,                  
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>
            <?php
                            
                            echo "</div></div>";
                        }
                        
                        if ($type == 'applicant_category') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
				            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                                            <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[ // 2 column layout
	$name => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label'=>false,
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                       'options' => [
                        'prompt' => 'Select Category',
                        
                    ],
                ],
            ],
        ]
    ]); ?>
                            <?php
				            echo "</div></div>";
                        }
                        ?>
            <?php
                        
                        if ($type == 'institution') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
				            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                                            <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[ // 2 column layout
	$name => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label'=>false,
                  'options' => [
                      'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type'=>['UNIVERSITY','COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
                       'options' => [
                        'prompt' => 'Select Institution',
                        
                    ],
                ],
            ],
        ]
    ]); ?>
            <?php
				            echo "</div></div>";
                        }
                        
                        if ($type == 'loan_item') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
				            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                                            <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[ // 2 column layout
	$name => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label'=>false,
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->all(), 'loan_item_id', 'item_name'),
                       'options' => [
                        'prompt' => 'Select Loan Item',
                        
                    ],
                ],
            ],
        ]
    ]); ?>
            
            <?php
				            echo "</div></div>";
                        }
                        
                        if ($type == 'country') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
				            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                                            <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[ // 2 column layout
	$name => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label'=>false,
                  'options' => [
                      'data' => ArrayHelper::map(\frontend\modules\application\models\Country::find()->all(), 'country_id', 'country_name'),
                       'options' => [
                        'prompt' => 'Select Country',
                        
                    ],
                ],
            ],
        ]
    ]); ?>
            <?php
				            echo "</div></div>";
                        }
                        
                        if ($type == 'programme_group') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
				            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                                            <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[ // 2 column layout
	$name => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label'=>false,
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\allocation\models\ProgrammeGroup::find()->all(), 'programme_group_id', 'group_name'),
                       'options' => [
                        'prompt' => 'Select Programme Group',
                        
                    ],
                ],
            ],
        ]
    ]); ?>
            <?php
				            echo "</div></div>";
                        }
                        
                        if ($type == 'scholarship_type') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
				            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                                            <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[ // 2 column layout
	$name => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label'=>false,
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\allocation\models\ScholarshipDefinition::find()->all(), 'scholarship_id', 'scholarship_name'),
                       'options' => [
                        'prompt' => 'Select Scholarship Type',
                        
                    ],
                ],
            ],
        ]
    ]); ?>
            <?php
				            echo "</div></div>";
                        }
                        
                        if ($type == 'academic_year') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
				            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                                            <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[ // 2 column layout
	$name => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label'=>false,
                  'options' => [
                      'data' => ArrayHelper::map(\common\models\AcademicYear::find()->all(), 'academic_year_id', 'academic_year'),
                       'options' => [
                        'prompt' => 'Select Academic Year',
                        
                    ],
                ],
            ],
        ]
    ]); ?>
                            <?php
				            echo "</div></div>";
                        }
                        ?>
                        <?php
                        if ($type == 'sex') {
                            echo "<div class='form-group'><label class='col-md-3'>" . $model->$field . "</label><div class='col-md-9'>";
				            //echo CHtml::textField($name, $value, array('size' => 20,'class'=>'form-control'));
                            ?>
                                            <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[ // 2 column layout        
        $name=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label'=>false,
                'options' => [
                    'data' => ['M'=>'Male', 'F'=>'Female'],
                    'options' => [
                        'prompt' => 'Select Sex ',
                   
                    ],
                ],
             ],
        
        ]
    ]); ?>
                            <?php
				            echo "</div></div>";
                        }
                        
                        /*else{
                            echo "<div class='form-group'><label class='col-md-3'>".$model->$field."</div><label class='col-md-3'>
                            ".CHtml::textField($name,$value,array('size'=>20))."
                            </div>";
                        }*/
                    }
                }
                ?>
            
                   <?php echo "<div class='form-group'><label class='col-md-3'>" . "EXPORT" . "</label><div class='col-md-9'>";?>
                    <?= $form->field($model, 'exportCategory')->label(false)->dropDownList([ '1' => 'PDF', '2' => 'EXCEL', ], ['prompt' => 'Select']) ?>
                   <?php echo "</div></div>"; ?>  
<div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Generate' : 'Generate', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);
?>
    </div>

        </div>
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
