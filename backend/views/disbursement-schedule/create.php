<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementSchedule */

$this->title = 'Create Disbursement Schedule';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-schedule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
