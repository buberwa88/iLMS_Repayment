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
            <div class="form-group">
                <label class="col-lg-3 control-label">Export</label>
                <div class="col-lg-9">
                    <?= $form->field($model, 'file_field')->label(false)->dropDownList([ '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', ], ['prompt' => 'Select']) ?>
                    <span class="help-block text-danger"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Export</label>
                <div class="col-lg-9">
                    <?= $form->field($model, 'file_field')->label(false)->dropDownList([ '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', ], ['prompt' => 'Select']) ?>
                    <span class="help-block text-danger"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Export</label>
                <div class="col-lg-9">
                    <?= $form->field($model, 'exportCategory')->label(false)->dropDownList([ '1' => 'PDF', '2' => 'EXCEL', ], ['prompt' => 'Select']) ?>
                    <span class="help-block text-danger"></span>
                </div>
            </div>
            <div class="form-group">
           <label class="col-lg-3 control-label">Page Orientation</label>
            <div class="col-lg-9">
                <?= $form->field($model, 'category')->label(false)->dropDownList([ '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', ], ['prompt' => 'Select']) ?>               
                <span class="help-block text-danger"></span>
            </div>
        </div>
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
