<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationCustomCriteriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Verification Custom Criterias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-custom-criteria-index">
<div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">
  <?=
kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'criteria_name',
        'applicant_source_table',
        'applicant_souce_column',
        'operator',
        'applicant_source_value',
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
           
                        [
'class'    => 'yii\grid\ActionColumn',
'template' => '{update}',
]
                        
                        
            ],
        ]);
        ?>
</div>
  </div>
</div>
