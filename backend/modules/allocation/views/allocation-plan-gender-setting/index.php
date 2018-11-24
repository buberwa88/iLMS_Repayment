<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationPlanGenderSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Plan Gender';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-gender-setting-index">
        <div class="panel panel-info">

            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">

    <p>
        <?= Html::a('Create Allocation Plan Gender', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'allocation_plan_gender_setting_id',
            [
                'attribute'=>'allocation_plan_id',
                'label'=>'Allocation Plan',
                'value'=>function($model){
                    return $model->allocationPlan->allocation_plan_title;
                },
            ],
            'female_percentage',
            'male_percentage',

            ['class' => 'yii\grid\ActionColumn',
             'template'=>'{update}',   
                ],
        ],
    ]); ?>
            </div>
        </div>
    </div>
