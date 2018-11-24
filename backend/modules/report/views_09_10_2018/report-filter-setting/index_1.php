<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ReportFilterSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Filter Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-filter-setting-index">
<div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Create Report Filter Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'report_filter_setting_id',
            'number_of_rows',
            //'is_active',
            //'created_by',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn','template'=>'{update}'],
        ],
    ]); ?>
</div>
  </div>
</div>
