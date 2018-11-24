<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

$this->title = 'Grants & Scholarships';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-field-index">
    <div class="panel panel-info">
        <div class="panel-heading">

        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Add Grant/Scholarship', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'scholarship_name',
                    [
                        'attribute' => 'is_full_scholarship',
                        'value' => function($model) {
                            return $model->getScholarshipTypeName();
                        }
                    ],
                    'sponsor',
                    [
                        'attribute' => 'country_of_study',
                        'value' => 'country.country_name'
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>  
