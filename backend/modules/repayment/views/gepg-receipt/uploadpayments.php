<?php

use yii\helpers\Html;
?>    
   <?php 
/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = 'Upload Payments';
$this->params['breadcrumbs'][] = ['label' => 'Upload Payments', 'url' => ['upload-payments']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-create">

<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('upload', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
