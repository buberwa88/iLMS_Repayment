<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\Disbursement */

$this->title = "View Disbursement Details";
$this->params['breadcrumbs'][] = ['label' => 'Disbursements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-view">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
             <?= Html::a('Return Back', ['disbursed', 'id' => $model->disbursement_batch_id], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->disbursement_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->disbursement_id], [
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
            //'disbursement_id',
            'disbursement_batch_id',
           // 'application_id',
            'programme.programme_name',
            'loanItem.item_name',
            'disbursed_amount',
           // 'status',
            'created_at',
            //'created_by',
        ],
    ]) ?>

</div>
</div>
</div>