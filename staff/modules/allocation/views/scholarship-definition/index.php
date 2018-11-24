<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\ScholarshipDefinitionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Scholarship Definitions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scholarship-definition-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Scholarship Definition', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'scholarship_id',
            'scholarship_name',
            'scholarship_desc',
            'sponsor',
            'country_of_study',
            // 'start_year',
            // 'end_year',
            // 'is_active',
            // 'closed_date',
            // 'is_full_scholarship',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
