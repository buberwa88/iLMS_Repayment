<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\ProgrammeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Programmes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Programme', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'programme_id',
            'learning_institution_id',
            'programme_code',
            'programme_name',
            'years_of_study',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
