<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\CriteriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Criteria';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Criteria', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
           // 'criteria_id',
            'criteria_description',
               [
                        'attribute' => 'is_active',
                        'vAlign' => 'middle',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
       'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
 </div>
</div>