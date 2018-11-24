<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementUserStructure */

$this->title = 'Update Disbursement User Structure: ' . $model->disbursement_user_structure_id;
$this->params['breadcrumbs'][] = ['label' => 'Disbursement User Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->disbursement_user_structure_id, 'url' => ['view', 'id' => $model->disbursement_user_structure_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-user-structure-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
