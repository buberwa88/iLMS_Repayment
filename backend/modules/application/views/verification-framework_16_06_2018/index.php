<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationFrameworkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Verification Frameworks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-framework-index">

<div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Create Verification Framework', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'verification_framework_id',
            'verification_framework_title',
            'verification_framework_desc',
            //'verification_framework_stage',
            [
                     'attribute' => 'verification_framework_stage',
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->verification_framework_stage ==0){
                                     return Html::label("No", NULL, ['class'=>'label label-danger']);
                                    } else if($model->verification_framework_stage==1) {
                                        return Html::label("Yes", NULL, ['class'=>'label label-success']);
                                    }
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[1=>"Yes",0=>'No'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
                                [
                     'attribute' => 'is_active',
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->is_active ==0){
                                     return Html::label("No", NULL, ['class'=>'label label-danger']);
                                    } else if($model->is_active==1) {
                                        return Html::label("Yes", NULL, ['class'=>'label label-success']);
                                    }
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[1=>"Yes",0=>'No'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
            //'created_at',
            // 'created_by',
            // 'confirmed_by',
            // 'confirmed_at',
            // 'is_active',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{view}'],
        ],
    ]); ?>
</div>
  </div>
</div>
