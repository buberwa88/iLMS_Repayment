<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\LoanRepaymentSetting */

$this->title = 'Loan Repayment Item: ' .$model->loanRepaymentItem->item_name;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-setting-view">

    <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->loan_repayment_setting_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->loan_repayment_setting_id], [
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
            //'loan_repayment_setting_id',
            //'loan_repayment_item_id',
            [
                'attribute'=>'loan_repayment_item_id',
                'value'=>$model->loanRepaymentItem->item_name,
            ],
            'start_date',
            'end_date',
            //'percent',
            [
                'attribute'=>'percent',
                'label'=>'Percent(%)',
                'value'=>$model->percent,
            ],
            //'created_at',
            //'created_by',
        ],
    ]) ?>

</div>
    </div>
</div>
