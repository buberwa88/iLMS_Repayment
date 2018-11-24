<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Verifications Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-assignment-index">
<div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>               
        <?php
//        $results=backend\modules\application\models\VerificationAssignment::getTotalApplicationByCategory();
//        echo "Total: Diploma => ".number_format($results->Diploma).", "." Bachelor => ".number_format($results->Bachelor).", "." Masters => ".number_format($results->Masters).", "." Postgraduate Diploma => ".number_format($results->Postgraduate_Diploma).", "." PhD => ".number_format($results->PhD);
        echo $this->render('_details');
        ?>
        <br/>
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
                       
                       'filterType' => GridView::FILTER_SELECT2,
                        //'filter' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where("is_active=1")->asArray()->all(), 'loan_item_id', 'item_name'),
                        'filter' =>ArrayHelper::map(\common\models\User::findBySql('SELECT user.user_id,CONCAT(user.firstname," ",user.surname) AS "Name" FROM `user` INNER JOIN verification_assignment ON verification_assignment.assignee=user.user_id  WHERE user.login_type=5')->asArray()->all(), 'user_id', 'Name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search  '],
                        'format' => 'raw'
                        
                    ],
                                [
                     'attribute' => 'assigned_by',
                     'label'=>'Assigned By',
                        'value' => function ($model) {
                                   
                                     return $model->assignedBy->firstname." ".$model->assignedBy->middlename." ".$model->assignedBy->surname;
                                    
                        }, 

                      'filterType' => GridView::FILTER_SELECT2,
                        //'filter' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where("is_active=1")->asArray()->all(), 'loan_item_id', 'item_name'),
                        'filter' =>ArrayHelper::map(\common\models\User::findBySql('SELECT user.user_id,CONCAT(user.firstname," ",user.surname) AS "Name" FROM `user` INNER JOIN verification_assignment ON verification_assignment.assigned_by=user.user_id  WHERE user.login_type=5')->asArray()->all(), 'user_id', 'Name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search  '],
                        'format' => 'raw'
                                      
                    ],
            'created_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
  </div>
</div>
