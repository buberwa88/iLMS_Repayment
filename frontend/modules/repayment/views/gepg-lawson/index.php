<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\GepgLawsonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gepg Lawsons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-lawson-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gepg Lawson', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'gepg_lawson_id',
            'bill_number',
            'amount',
            'control_number',
            'control_number_date',
            // 'deduction_month',
            // 'status',
            // 'gepg_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
