<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\Refund */

$this->title = 'Add New Refund Claim';
$this->params['breadcrumbs'][] = ['label' => 'Refunds', 'url' => ['/repayment/loan-beneficiary/view-loanee-details-refund','id'=>$applicantID]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-create">
	<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,'applicantID'=>$applicantID,'upID'=>$upID,
    ]) ?>

</div>
    </div>
</div>
