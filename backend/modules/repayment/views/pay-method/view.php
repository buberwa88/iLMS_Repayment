<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\PayMethod */

$this->title = 'Payment Method: ' .$model->method_desc;
$this->params['breadcrumbs'][] = ['label' => 'Payment Methods', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="payment-method-view">
    <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'pay_method_id',
            'method_desc',
        ],
    ]) ?>
<div class="text-right">
  <?= Html::a('Update', ['update', 'id' => $model->pay_method_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pay_method_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
	<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>	
    </div>
</div>
    </div>
</div>
