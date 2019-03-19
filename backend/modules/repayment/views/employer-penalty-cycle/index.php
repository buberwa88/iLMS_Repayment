<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\EmployerPenaltyCycleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employer Penalty Cycles';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">

        <p>
            <?= Html::a('Create/Set Employer Penalty Cycle', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'employer_id',
                    'value' => function($model) {
                        return $model->employer_id ? $model->employer->employer_name : 'ALL';
                    }
                ],
                'repayment_deadline_day',
                'penalty_rate',
                'duration',
                [
                    'attribute' => 'duration_type',
                    'value' => function($model) {
                        return $model->getDurationTypeName();
                    }
                ],
                [
                    'attribute' => 'is_active',
                    'value' => function($model) {
                       return $model->is_active? 'Active' : 'In Active'; 
                    }
                ],
                [
                    'attribute' => 'cycle_type',
                    'value' => function($model) {
                        return $model->getCycleTypeName();
                    },
                ],
                'start_date',
                'end_date',
                //['class' => 'yii\grid\ActionColumn'],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Actions',
                    'headerOptions' => ['style' => 'color:#337ab7'],
                    'template' => '{update}{delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return $model->is_active==1 ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'update'),
                            ]):'';
                        },
                        'delete' => function ($url, $model) {
                            return \backend\modules\repayment\models\EmployerPenaltyCycle::checkItemUsed()==0? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                //'class' => 'btn btn-info',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    //'method' => 'get',
                                    //'title' => Yii::t('app', 'lead-update'),
                                ],
                            ]):'';
                        }

                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'update') {
                            $url ='index.php?r=repayment/employer-penalty-cycle/update&id='.$model->employer_penalty_cycle_id;
                            return $url;
                        }
                        if ($action === 'delete') {
                            $url ='index.php?r=repayment/employer-penalty-cycle/delete-penaltycycle&id='.$model->employer_penalty_cycle_id;
                            return $url;
                        }

                    }
                ],

            ],
        ]);
        ?>
    </div>
