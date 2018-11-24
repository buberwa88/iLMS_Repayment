<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\Appeal */

$this->title = 'Appeal';
$this->params['breadcrumbs'][] = ['label' => 'Appeals', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Appeal';

$js = "$(document).ready(function(){
    $('#neednessQn').click(function(){
        
        var selecteOption = $(this).val();

        if(selecteOption == '1'){
            $('#neednessBtn').removeAttr('disabled');
        }else{
            $('#neednessBtn').attr('disabled','disabled');
        }
        console.log('Halleluyah'+$(this).data('appealqnid'));
    });
})";

$this->registerJs($js);
?>
<div class="appeal-category-view">
    <div class="panel panel-info">
        
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        
        <div class="panel-body">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'applicantfullname',
                    'application.programme.learningInstitution.institution_name',
                    'appealCategory.name',
                    'bill_number',
                    'control_number',
                    'receipt_number',
                    'amount_paid',
                    'pay_phone_number',
                    'current_study_year',
                    'needness',
                ],
            ]) ?>

            <br/>
            <?= HTML::label('Appeal Questions') ?>
            <br/><br/>

            <?= GridView::widget([
                'dataProvider' => $appealAttachments,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'appealQuestion.question.question',
                    [
                        'label' => 'Attacment',
                        'format' => 'raw', 
                        'value' => function ($model) {
                            return Html::a($model->attachment_path, ['appeal/download', 'id'=>$model->appeal_attachment_id]);
                        }
                    ],
                    [
                        'label' => 'Verification Status',
                        'format' => 'raw', 
                        'value' => function ($model) {
                            if($model->verification_status){
                                return "<b class='fa fa-check-circle'></b> Passed";
                            }else{
                                return "<b class='fa fa-times'></b> Failed";
                            };
                        }
                    ],               
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{valid}{invalid}',
                        'buttons' => ['valid' => function($url, $model) {
                            return Html::a('<span class="btn btn-sm btn-success"><b class="fa fa-check-circle"></b> Passed</span>', ['appeal/attachment-status', 'id'=>$model->appeal_attachment_id, 'status'=>'1'], ['title' => 'Valid Request', 'id' => 'modal-btn-view', 'data' => ['confirm' => 'Is the attachment provided valid ?', 'method' => 'get', 'data-pjax' => false]]);
                        },
                        'invalid' => function($url, $model) {
                            return Html::a('<span class="btn btn-sm btn-danger" style="margin-left:10px"><b class="fa fa-times"></b> Failed</span>', ['appeal/attachment-status', 'id'=>$model->appeal_attachment_id, 'status'=>'0'], ['title' => 'Not Valid Request', 'class' => '', ]);
                        }
                    ]
                ],
                ],
            ]); ?>

            <?= HTML::label('Calculate new needness?',null,['class'=>'form-label']) ?>

            <?= Html::dropDownList('needness', null, ['0'=>'No', '1'=>'Yes'], ['id'=>'neednessQn', 'prompt'=>'Select Option', 'class'=>'form-control']) ?>

            <br/>
            <p class="pull-right">
                <?= Html::a('Calcluate Neednes Test', ['#'], ['id'=>'neednessBtn', 'disabled'=>'disabled', 'class' => 'btn btn-primary']) ?>
                
            </p>
        </div>
    </div>
</div>

