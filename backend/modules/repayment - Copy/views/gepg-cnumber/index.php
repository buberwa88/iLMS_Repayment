<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\GepgCnumberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gepg Cnumbers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-cnumber-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gepg Cnumber', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'bill_number',
            'response_message',
            'retrieved',
            'control_number',
            // 'trsxsts',
            // 'trans_code',
            // 'date_received',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
