<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationFrameworkItem */

$this->title = 'Update Verification Framework Item: ' . $model->verification_framework_item_id;
$this->params['breadcrumbs'][] = ['label' => 'Verification Framework Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->verification_framework_item_id, 'url' => ['view', 'id' => $model->verification_framework_item_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="verification-framework-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
