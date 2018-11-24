<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementStructure */

$this->title = 'Update Disbursement Structure: ' . $model->disbursement_structure_id;
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->disbursement_structure_id, 'url' => ['view', 'id' => $model->disbursement_structure_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-structure-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
