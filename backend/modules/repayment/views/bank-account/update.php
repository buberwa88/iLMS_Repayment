<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\BankAccount */

$this->title = 'Update Bank Account: ' . $model->account_number;
$this->params['breadcrumbs'][] = ['label' => 'Bank Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->account_number, 'url' => ['view', 'id' => $model->bank_account_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bank-account-update">

<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
