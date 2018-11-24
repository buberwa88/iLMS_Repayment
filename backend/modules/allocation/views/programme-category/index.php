<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\ProgrammeCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Programme Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-category-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create Programme Category', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //  'programme_category_id',
                    'programme_category_name',
                    'programme_category_desc',
                    [
                        'attribute' => 'is_active',
                        'value' => function($model) {
                            return $model->getStatusNameByValue();
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}'],
                ],
                'hover' => true,
                'condensed' => true,
                'floatHeader' => true,
            ]);
            ?>
        </div>
    </div>
</div>