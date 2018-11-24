<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Appeals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appeal-index">

    <div class="panel panel-info">
    
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        
        <div class="panel-body">
            <br><br>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'applicantfullname',
                    'application.application_study_year',
                    'application.programme.learningInstitution.institution_name',
                    // 'amount_paid',
                    // 'pay_phone_number',
                    // 'date_bill_generated',
                    // 'date_control_received',
                    // 'date_receipt_received',
                    // 'current_study_year',
                    // 'verification_status',
                    // 'needness',
                    // 'created_at',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{create}',
                        'buttons' => ['view' => function($url, $model) {
                            return Html::a('<b class="fa fa-eye"></b>', ['appeal/view', 'id'=>$model->appeal_id]);
                        },
                        'create' => function($url, $model) {
                            return Html::a('Create Appeal', ['appeal/create', 'id'=>$model->appeal_id], ['title' => 'Not Valid Request', 'style' => 'margin-left:50px', ]);
                        }
                    ]
                ]
                ],
            ]); ?>
        </div>
    </div>
</div>

             
                    