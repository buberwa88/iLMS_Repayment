<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = 'Update Beneficiary';
$this->params['breadcrumbs'][] = ['label' => 'Double Employed', 'url' => ['mult-employed','id' => $model->applicant_id]];
$this->params['breadcrumbs'][] = ['label' => $model->employed_beneficiary_id, 'url' => ['view', 'id' => $model->employed_beneficiary_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employed-beneficiary-update">
<div class="panel panel-info">
        <div class="panel-heading">
        <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_formDeactivateEmplee', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
