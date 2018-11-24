<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummaryDetail */

$this->title = 'Create Loan Repayment Bill Detail';
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Bill Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-summary-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
