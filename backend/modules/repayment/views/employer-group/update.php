<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerGroup */

$this->title = 'Update Employer Group: ' . $model->employer_group_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employer_group_id, 'url' => ['view', 'id' => $model->employer_group_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
