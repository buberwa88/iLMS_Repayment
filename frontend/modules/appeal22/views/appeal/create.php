<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\Appeal */

$this->title = 'Create Appeal';
$this->params['breadcrumbs'][] = ['label' => 'Appeals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$js = "$(document).ready(function(){
    $('.appeal_question').click(function(){
        
        var appealQnId = $(this).data('appealqnid');

        var selecteOption = $(this).val();

        if(selecteOption == '1'){
            $('#attachment-container-'+appealQnId).css({ 'display': 'block' });
        }else{
            $('#attachment-'+appealQnId).val('');
            $('#attachment-container-'+appealQnId).css({ 'display': 'none' });
        }
        console.log('Halleluyah'+$(this).data('appealqnid'));
    });
})";

$this->registerJs($js);
?>

<div class="appeal-create">

    <div class="customer-form">

        <?= Html::beginForm(['appeal/store', 'id'=>$appeal->appeal_id], 'post', ['enctype' => 'multipart/form-data']) ?>
        
        <?= Html::csrfMetaTags() ?>

        <div class="row">
            <div class="col-sm-6">
              
            </div>
            <div class="col-sm-6">

            </div>
        </div>

        <div class="padding-v-md">
            <div class="line line-dashed"></div>
        </div>
      
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-envelope"></i> Create Appeal
               
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items"><!-- widgetContainer -->

                <?= Html::label('Appeal Type', null, ['class' => 'form-label']) ?>
                <?= Html::activeDropDownList($model, 'appeal_category_id', ArrayHelper::map($appealCategories, 'appeal_category_id', 'name'),  ['prompt'=>'Select Appeal Type','class'=>'form-control'] ) ?>

                <br/>
                <?php foreach($appealQuestions as $aq) {?>
                    
                    <div class="form-group">
                        <?= Html::label($aq->getQuestionString()." ?", null, ['class' => 'form-label']) ?>
                        <br/>
                        <?= Html::radio('qn['.$aq->appeal_question_id.']', false, ['label'=>'Yes', 'value'=>'1', 'data-appealqnid'=>$aq->appeal_question_id, 'class'=>'form-radio appeal_question'] ) ?>
                        <?= Html::radio('qn['.$aq->appeal_question_id.']', true, ['label'=>'No', 'value'=>'0', 'data-appealqnid'=>$aq->appeal_question_id, 'class'=>'form-radio appeal_question'] ) ?>

                        <span class="form-group" style='display:none' id='attachment-container-<?= $aq->appeal_question_id ?>'>
                            <?= Html::label("Uploading Support Document", null, ['class' => 'form-label']) ?>
                            <?= Html::fileInput('answ['.$aq->appeal_question_id.']', null, ['id'=>'attachment-'.$aq->appeal_question_id, 'class'=>'form-control']) ?>
                        </span>
                    </div>

                    <br/><br/>
            
                <?php }?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
                </div>
            </div>
        </div>
       
        <?= Html::endForm() ?>

</div>
