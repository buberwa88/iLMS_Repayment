<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimantEducationHistory */

$this->title = 'Create Refund Claimant Education History';
$this->params['breadcrumbs'][] = ['label' => 'Refund Claimant Education Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-claimant-education-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
