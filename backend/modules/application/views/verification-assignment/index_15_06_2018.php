<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Verifications Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-assignment-index">
<div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
        <br/>       
        <?php
        $results=backend\modules\application\models\VerificationAssignment::getTotalApplicationByCategory();
        echo "Total: Diploma => ".number_format($results->Diploma).", "." Bachelor => ".number_format($results->Bachelor).", "." Masters => ".number_format($results->Masters).", "." Postgraduate Diploma => ".number_format($results->Postgraduate_Diploma).", "." PhD => ".number_format($results->PhD);
        ?>
    </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Assign', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'verification_assignment_id',            
            [
                     'attribute' => 'study_level',
                     'label'=>'Study Level',
                        'value' => function ($model) {
                                   
                                     return $model->studyLevel->applicant_category;
                                    
                        },                        
                    ],
            'total_applications',
                                [
                     'attribute' => 'assignee',
                     'label'=>'Assignee',
                        'value' => function ($model) {
                                   
                                     return $model->assignee0->firstname." ".$model->assignee0->middlename." ".$model->assignee0->surname;
                                    
                        },                        
                    ],
                                [
                     'attribute' => 'assigned_by',
                     'label'=>'Assigned By',
                        'value' => function ($model) {
                                   
                                     return $model->assignedBy->firstname." ".$model->assignedBy->middlename." ".$model->assignedBy->surname;
                                    
                        },                        
                    ],
            'created_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
  </div>
</div>
