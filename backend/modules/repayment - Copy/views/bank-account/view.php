<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\BankAccount */

$this->title = 'Bank Accounts: ' .$model->account_number;
$this->params['breadcrumbs'][] = ['label' => 'Bank Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-account-view">

<div class="panel panel-info">
        <div class="panel-heading">
       
        </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->bank_account_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->bank_account_id], [
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
            //'bank_account_id',
            [
                'attribute'=>'bank_id',
                'value'=>$model->bank->bank_name,
            ],
            'branch_name',
            'account_name',
            'account_number',
            [
                'attribute'=>'currency_id',
                'value'=>$model->currency->currency_ref,
            ],
            //'currency_id',
        ],
    ]) ?>

</div>
    </div>
</div>
