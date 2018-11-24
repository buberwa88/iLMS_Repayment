<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = 'Add New Employee';
$this->params['breadcrumbs'][] = ['label' => 'Employed Beneficiaries', 'url' => ['index-view-beneficiary']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-create">
<div class="panel panel-info">
        <div class="panel-heading">
        <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_formAdditionalEmployee', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
