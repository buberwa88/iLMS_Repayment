<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\PayoutlistMovement */

$this->title = $model->movement_id;
$this->params['breadcrumbs'][] = ['label' => 'Payoutlist Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payoutlist-movement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->movement_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->movement_id], [
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
            'movement_id',
            'disbursements_batch_id',
            'from_officer',
            'to_officer',
            'movement_status',
            'date_in',
            'date_out',
        ],
    ]) ?>

</div>
