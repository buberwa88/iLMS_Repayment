<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\Loan */

$this->title = 'Update Loan: ' . $model->loan_id;
$this->params['breadcrumbs'][] = ['label' => 'Loans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->loan_id, 'url' => ['view', 'id' => $model->loan_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
