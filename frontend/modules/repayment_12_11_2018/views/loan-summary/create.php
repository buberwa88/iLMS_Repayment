<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */

$this->title = 'Loan Repayment Bill';
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-summary-create">
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
