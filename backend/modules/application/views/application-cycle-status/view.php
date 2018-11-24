<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationCycleStatus */

$this->title = $model->application_cycle_status_name;
$this->params['breadcrumbs'][] = ['label' => 'Application Status', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-cycle-status-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->application_cycle_status_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->application_cycle_status_id], [
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
            'application_cycle_status_id',
            'application_cycle_status_name',
            'application_cycle_status_description',
        ],
    ]) ?>

</div>
