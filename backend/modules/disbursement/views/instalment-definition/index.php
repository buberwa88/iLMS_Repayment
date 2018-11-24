<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\InstalmentDefinitionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Instalment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instalment-definition-index">
   <div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <p>
        <?= Html::a('Create Instalment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'instalment_definition_id',
            'instalment',
            'instalment_desc',
           // 'is_active',
                [
                        'attribute' => 'is_active',
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->is_active==1?'Active':'Inactive';
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[1=>'Active',2=>'Inactive'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}'],
        ],
     'hover' => true,
     'condensed' => true,
     'floatHeader' => true,
    ]); ?>
</div>
   </div>
</div>