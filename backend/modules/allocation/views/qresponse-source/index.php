<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\QresponseSourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Question Response Source';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qresponse-source-index">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Question Response Source', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'qresponse_source_id',
            'source_table',
            'source_table_value_field',
            'source_table_text_field',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
 </div>
</div>