<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Complaint Token';
$this->params['breadcrumbs'][] = $this->title;

$this->title = 'Create Complaint Token';
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="complaint-index">
    <div class="panel panel-info">

        <div class="complaint-create">
            <div class="panel-body">
                <div class="complaint-form">

                    <?= Html::beginForm("index.php?r=appeal/complaints/create-token","POST", ["enctype"=>"multipart/form-data"]); ?>
                   

                        <div class="form-group">
                            <?= Html::label("Token Type") ?>
                            <?= Html::dropDownList('type', 'single', ['single'=>'Single', 'multiple'=>'Multiple'], ['id'=>'type','class'=>'form-control']) ?>
                        </div>

                        <br/>
                        <div class="form-group" id="formIndexNumberContainer">
                            <?= Html::label("Form IV Index Number") ?>
                            <?= Html::textInput('indexNumber', null,['id'=>'type','class'=>'form-control']) ?>
                        </div>

                        <div class="form-group" style="display: none" id="fileContainer">
                            <?= Html::label("File") ?>
                            <?= Html::fileInput('file', null, ['id'=>'type','class'=>'form-control']) ?>
                        </div>

                        <br/>
                        <div class="form-group">

                            <?= Html::a('Cancel', ['tokens'], ['class' => 'btn btn-danger pull-right', 'style'=>'margin-left:20px']) ?>

                            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary  pull-right']) ?>

                            <?= Html::resetButton('Reset', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary  pull-right', 'style'=>'margin-right:20px']) ?>

                        </div>

                    
                    <?php Html::endForm(); ?>


                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $this->registerJs('
            $("#type").change(function(){
                
                var type = $(this).val();
                
                if(type == "multiple"){
                    $("#formIndexNumberContainer").css("display","none");
                    $("#fileContainer").css("display","block");
                }else{
                    $("#fileContainer").css("display","none");
                    $("#formIndexNumberContainer").css("display","block");
                }
                
                console.log("xxx");
            })'
    );
?>
