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
            <?php if($appeal->submitted == 0) { ?>
                <p class='alert alert-danger'>   
                    <strong>This appeal is not yet submitted, please confirm the details and click the submit button at the end of this page</strong>
                </p>
            <?php } else {
                  echo '<span class="label label-primary">Status</span>:&nbsp;<span class="label label-danger"> InProgress</span></span><br><br>';
            } ?>


            <?= DetailView::widget([
                'model' => $appeal,
                'attributes' => [
                    'bill_number',
                    'control_number',
                    'receipt_number',
                    'amount_paid',
                    'pay_phone_number',
                    'current_study_year',
                    'needness',
                ],
            ]) ?>

            <?= HTML::label('Appeal Questions') ?>

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
                            if($model->verification_status == -1){
                                return "InProgress";
                            }else if($model->verification_status == 1){
                                return "Passed";
                            }else{
                                return "Failed";
                            }
                        }
                    ],               
                    [
                        
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function($url, $model) {
                                if($model->appeal->submitted == 0){
                                    return Html::a('<b class="fa fa-trash"></b>', 
                                        ['appeal/delete-attachment', 'id'=>$model->appeal_attachment_id], 
                                    
                                            [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                ],
                                            ]
                                
                                    );
                                }
                            }
                        ]
                ],
                ],
            ]); ?>

            <?php if($appeal->submitted == 0) { ?>
                <p class="pull-right">

                    <?= Html::a('Edit', ['appeal/update', 'id'=>$appeal->appeal_id], ['class' => 'btn btn-primary']) ?>

                    <?= Html::a('Submit', ['appeal/submit-appeal', 'id'=>$appeal->appeal_id], ['id'=>'neednessBtn', 'class' => 'btn btn-primary',
                                    'data' => [
                                            'confirm' => 'Are you sure you want to submit this appeal?',
                                    ],]) ?>
                
                </p>
            <?php } ?>
        </div>
    </div>
</div>

