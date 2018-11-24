<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealQuestion */

$this->title = $model->appeal_question_id;
$this->params['breadcrumbs'][] = ['label' => 'Appeal Question', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appeal-question-view">
    <div class="panel panel-info">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            
            <div class="panel-body">
                <div>
                    <?php 
                        $gridColumn = [
                            'appeal_question_id',
                            [
                                'attribute' => 'question.question',
                                'label' => 'Question',
                            ],
                            [
                                'attribute' => 'attachmentDefinition.attachment_definition_id',
                                'label' => 'Attachment Definition',
                            ],
                        ];
                        echo DetailView::widget([
                            'model' => $model,
                            'attributes' => $gridColumn
                        ]);
                    ?>
                </div>

                <div>
                
                <div class="col-sm-3 pull-right" style="margin-top: 15px">
                    
                    <?= Html::a('Update', ['update', 'id' => $model->appeal_question_id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->appeal_question_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
                </div>
            </div>

            </div>
    </div>
</div>