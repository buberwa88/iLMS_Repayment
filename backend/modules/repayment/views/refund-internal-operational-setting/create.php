<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundInternalOperationalSetting */

$this->title = 'Create Refund Internal Operational Setting';
$this->params['breadcrumbs'][] = ['label' => 'Refund Internal Operational Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-internal-operational-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
