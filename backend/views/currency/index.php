<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\controllers\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Currencies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Currency', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'currency_id',
            'currency_ref',
            'currency_postfix',
            'currency_desc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
