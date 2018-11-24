<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">
    <div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Configure Report', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'category',
            'file_name',
            'field1',
            // 'field2',
            // 'field3',
            // 'field4',
            // 'field5',
            // 'type1',
            // 'type2',
            // 'type3',
            // 'type4',
            // 'type5',
            // 'description1',
            // 'description2',
            // 'description3',
            // 'description4',
            // 'description5',
            // 'sql:ntext',
            // 'sql_where:ntext',
            // 'sql_order:ntext',
            // 'sql_group:ntext',
            // 'column1',
            // 'column2',
            // 'column3',
            // 'column4',
            // 'column5',
            // 'condition1',
            // 'condition2',
            // 'condition3',
            // 'condition4',
            // 'condition5',
            // 'package:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
  </div>
</div>
