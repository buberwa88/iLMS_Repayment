<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationReverseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Application Reverses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-reverse-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Application Reverse', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'application_reverse_id',
            'application_id',
            'comment:ntext',
            'reversed_by',
            'reversed_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
