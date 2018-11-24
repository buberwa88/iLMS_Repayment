<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Applicant */

$this->title = 'Update Applicant: ' . $model->applicant_id;
$this->params['breadcrumbs'][] = ['label' => 'Applicants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->applicant_id, 'url' => ['view', 'id' => $model->applicant_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="applicant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
