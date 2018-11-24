<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TempuploadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tempuploads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tempupload-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tempupload', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'file',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
