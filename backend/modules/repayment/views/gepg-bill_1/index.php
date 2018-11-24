<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\GepgBillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gepg Bills';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-bill-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gepg Bill', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'bill_number',
            'bill_request:ntext',
            'retry',
            'status',
            // 'response_message',
            // 'date_created',
            // 'cancelled_reason',
            // 'cancelled_by',
            // 'cancelled_date',
            // 'cancelled_response_status',
            // 'cancelled_response_code',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
