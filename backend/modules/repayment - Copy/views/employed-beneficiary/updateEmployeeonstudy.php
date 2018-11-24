<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = 'Update Beneficiary ONSTUDY';
$this->params['breadcrumbs'][] = ['label' => 'New Beneficiaries ONSTUDY', 'url' => ['new-employeeonstudy']];
$this->params['breadcrumbs'][] = ['label' => $model->employed_beneficiary_id, 'url' => ['view', 'id' => $model->employed_beneficiary_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employed-beneficiary-update">
<div class="panel panel-info">
        <div class="panel-heading">
        <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_form_employee_onstudy', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
