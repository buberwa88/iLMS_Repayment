<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ErpPopularReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Popular Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-popular-report-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp Popular Report', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'report_id',
            'rate',
            'set_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
