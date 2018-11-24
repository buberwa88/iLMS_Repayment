<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\ScholarshipProgrammeLoanItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Scholarship Programme Loan Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scholarship-programme-loan-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Scholarship Programme Loan Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'created_at',
            'academic_year_id',
            'scholarships_id',
            'programme_id',
            'loan_item_id',
            // 'rate_type',
            // 'unit_amount',
            // 'duration',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
