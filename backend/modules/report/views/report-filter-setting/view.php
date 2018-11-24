<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\ReportFilterSetting */

$this->title = $model->report_filter_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'Report Filter Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-filter-setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->report_filter_setting_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->report_filter_setting_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'report_filter_setting_id',
            'number_of_rows',
            'is_active',
            'created_by',
            'created_at',
        ],
    ]) ?>

</div>
