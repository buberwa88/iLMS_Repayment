<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimantEmployment */

$this->title = 'Create Refund Claimant Employment';
$this->params['breadcrumbs'][] = ['label' => 'Refund Claimant Employments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-claimant-employment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
