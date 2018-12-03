<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentPrepaid */

$this->title = 'Create Loan Repayment Prepaid';
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Prepaids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-prepaid-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
