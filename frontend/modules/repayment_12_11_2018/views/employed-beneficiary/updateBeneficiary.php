<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */
$this->title = 'Update Beneficiary';
?>
<div class="employed-beneficiary-update">
<div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_formUpdateBeneficiary', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
