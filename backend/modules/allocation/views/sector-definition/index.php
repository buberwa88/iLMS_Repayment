<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\SectorDefinitionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Sector';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sector-definition-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sector ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'sector_definition_id',
            'sector_name',
            'sector_desc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
 </div>
</div>