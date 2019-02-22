<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\GvtEmployee */

$this->title = 'Update Gvt Employee: ' . $model->gvt_employee;
$this->params['breadcrumbs'][] = ['label' => 'Gvt Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gvt_employee, 'url' => ['view', 'id' => $model->gvt_employee]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gvt-employee-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
