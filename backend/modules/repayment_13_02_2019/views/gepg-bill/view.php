<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgBill */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gepg Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-bill-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'bill_number',
            'bill_request:ntext',
            'retry',
            'status',
            'response_message',
            'date_created',
            'cancelled_reason',
            'cancelled_by',
            'cancelled_date',
            'cancelled_response_status',
            'cancelled_response_code',
        ],
    ]) ?>

</div>
