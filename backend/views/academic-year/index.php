<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AcademicYearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Academic Years';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academic-year-index">
       <div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Academic Year', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'academic_year_id',
            'academic_year',
            'is_current',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
       </div>
</div>