<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\EmployerMonthlyPenaltySettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employer Monthly Penalty';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-monthly-penalty-setting-index">
<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
						<p>
        <?= Html::a('Create Employer Monthly Penalty', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'employer_mnthly_penalty_setting_id',
			[
            'attribute'=>'employer_type_id',
            'format'=>'raw',    
            'value' => function($model)
            {   
            return $model->employerType->employer_type;
            },
        ],
            'payment_deadline_day_per_month',
            'penalty',
            [
                        'attribute' => 'is_active',
                        //'vAlign' => 'middle',
                        'label'=>"Status",
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->is_active==0?"Inative":"Active";
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [1=>'Active',0=>'Inactive'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ], 
            // 'created_at',
            // 'created_by',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
       </div>
</div>
