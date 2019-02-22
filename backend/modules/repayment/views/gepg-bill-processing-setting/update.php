<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgBillProcessingSetting */

$this->title = 'Update Gepg Bill Processing Setting';
$this->params['breadcrumbs'][] = ['label' => 'Gepg Bill Processing Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gepg_bill_processing_setting_id, 'url' => ['view', 'id' => $model->gepg_bill_processing_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gepg-bill-processing-setting-update">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
