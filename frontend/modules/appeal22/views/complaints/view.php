<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use backend\modules\appeal\models\Department;
use backend\modules\appeal\models\User;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\Complaint */

$this->title = "Complaint";
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Complaint";
?>

<div class="complaint-view">

    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
   
        <div class="panel-heading">
            <strong><?= Html::encode("Complaint") ?></strong>
        </div>
 
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute'=>'complaintCategory.complaint_category_name',
                    'label'=>'Category'
                ],
                'complaint:ntext',
                [
                    'attribute'=>'creatorName',
                    'label'=>'Applicant'
                ],
                'complaint_response:ntext',
                [
                    'attribute'=>'statusValue',
                    'label'=>'Status'
                ],
                [
                    'attribute'=>'lastAssignedOfficer',
                    'label'=>'Assigned Officer'
                ]
            ],
        ]) ?>

        <p class="pull-right">
            
            <?php 
                if(yii::$app->user->can('/appeal/complaints/update')) { ?>
            
                <?= Html::a('Edit', ['update', 'id' => $model->complaint_id], ['class' => 'btn btn-primary']) ?>
            <?php } ?>

            <?php 
                if(yii::$app->user->can('/appeal/complaints/delete')) { ?>
            
                <?= Html::a('Delete', ['delete', 'id' => $model->complaint_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>

            <?php } ?>
            
            <?php 
                if(yii::$app->user->can('/appeal/complaints/forward-heslb')) { ?>

                <?= Html::a('Submit Complaint', ['forward-heslb', 'id' => $model->complaint_id], [
                    'class' => 'btn btn-primary',
                    'data' => [
                        'confirm' => 'Are you sure you want to forward to IEC?',
                        'method' => 'post',
                    ],
                ]) ?>

            <?php } ?>

            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger pull-right', 'style'=>'margin-left:4px']) ?>

            <?php
                if(yii::$app->user->can('/appeal/complaints/assign')) {
                Modal::begin([
                    'header' => '<h4>Assign Complaint</h4>',
                    'toggleButton' =>   ['label' => 'Assign', 'class' => 'btn btn-primary'],
                ]);
            ?>
                <div class="panel-body">
                    <?= Html::beginForm("index.php?r=appeal/complaints/assign&id={$model->complaint_id}"); ?>
                    <div class="form-group">

                        <?= Html::label("Select Officer") ?>
                        
                        <br/><br/>

                        <?= 
                            Html::dropDownList('user_id', null,
                            ArrayHelper::map(User::find()->all(), 'user_id', 'fullName'), ['size'=>20,'class'=>'form-control','options'=>['size'=>'20']]) 
                        ?>
                    </div>
                    <br/>
                    <div class="form-group">
                        <?= Html::submitButton('Assign', ['class'=>'pull-right btn btn-primary']) ?>
                    </div>
                    <?= Html::endForm(); ?>     
                </div>
            <?php
                Modal::end();
                }
            ?>


            
            <?php
                if(yii::$app->user->can('/appeal/complaints/forward')) {
                    Modal::begin([
                        'header' => '<h4>Forward to Department</h4>',
                        'toggleButton' =>   ['label' => 'Forward', 'class' => 'btn btn-primary'],
                    ]);
            ?>
                <div class="panel-body">
                    <?= Html::beginForm("index.php?r=appeal/complaints/forward&id={$model->complaint_id}"); ?>
                    <div class="form-group">

                        <div class="form-group">
        
                            <?= Html::label("Select Department") ?>

                            <?= 
                                Html::dropDownList('to_department_id', null,
                                ArrayHelper::map(Department::find()->all(), 'department_id', 'department_name'), 
                                ['class'=>'form-control','prompt'=>'Select Department','options'=>['size'=>'20']]) 
                            ?>
                        </div>
                
                        <div class="form-group">
                            <br/><br/>

                            <?= Html::label("Description") ?>
                        
                            <?= Html::textarea('description',null,['class'=>'form-control','options'=>['size'=>'20']]) ?>
                        </div>
                    </div>
                    <br/>
                    <div class="form-group">
                        <?= Html::submitButton('Forward', ['class'=>'pull-right btn btn-primary pull-right']) ?>
                    </div>
                    <?= Html::endForm(); ?>
                        
                </div>
            <?php
                    Modal::end();
                }
            ?>

            <?php
                if(yii::$app->user->can('/appeal/complaints/respond')) {
                    Modal::begin([
                        'header' => '<h4>Respond to Complaint</h4>',
                        'toggleButton' =>   ['label' => 'Respond', 'class' => 'btn btn-primary'],
                    ]);
            ?>
                <div class="panel-body">
                    
                    <?= Html::beginForm("index.php?r=appeal/complaints/respond&id={$model->complaint_id}"); ?>
           
                    <div class="form-group">

                        <?= Html::label("Response") ?>
                    
                        <?= Html::textarea('complaint_response',null,['class'=>'form-control','options'=>['size'=>'20']]) ?>
                    </div>
                    
                    <br/>
                    <div class="form-group">
                        <?= Html::submitButton('Respond', ['class'=>'pull-right btn btn-primary pull-right']) ?>
                    </div>
                    <?= Html::endForm(); ?>
                        
                </div>
            <?php
                    Modal::end();
                }
            ?>

            
        </p>

        <br/>
        <div class="panel-heading">
                <strong><?= Html::encode("Department Movement") ?></strong>
        </div>
        <div class="panel-body">
            <?= GridView::widget([
                'dataProvider' => $movement,
                'columns' => [
                    [
                        'attribute'=>'creatorName',
                        'label' => 'From Officer'
                    ],
                    [
                        'attribute'=>'fromDepartmentName',
                        'label' => 'From Department'
                    ],
                    [
                        'attribute'=>'description',
                        'label'=>'Comments'
                    ],
                    [
                        'attribute'=>'toDepartmentName',
                        'label'=>'Final Department'
                    ],
                    [
                        'attribute'=>'assignedOfficer',
                        'label'=>'Assigned Officer'
                    ],
                ],
            ]); 
            ?>
  
        </div>
    </div>
</div>
</div>
