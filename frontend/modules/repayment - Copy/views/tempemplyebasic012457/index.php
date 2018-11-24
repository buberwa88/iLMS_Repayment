<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\Tempemplyebasic012457Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tempemplyebasic012457s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tempemplyebasic012457-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tempemplyebasic012457', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'loan_repayment_id',
            'applicant_id',
            'old_amount',
            'new_amount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
