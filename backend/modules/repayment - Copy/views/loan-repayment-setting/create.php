<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\LoanRepaymentSetting */

$this->title = 'Create Loan Repayment Setting';
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-setting-create">
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
