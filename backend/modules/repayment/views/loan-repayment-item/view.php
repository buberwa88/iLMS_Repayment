<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\LoanRepaymentItem */

$this->title = 'Loan Repayment Item: ' .$model->item_name;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-item-view">
    <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->loan_repayment_item_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->loan_repayment_item_id], [
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
            //'loan_repayment_item_id',
            'item_name',
            'item_code',
            //'is_active',
            [
                'attribute'=>'is_active',
                'value'=>$model->is_active==1 ? "Active":"In Active",
            ],
            //'created_at',
            //'created_by',
        ],
    ]) ?>

</div>
    </div>
</div>
