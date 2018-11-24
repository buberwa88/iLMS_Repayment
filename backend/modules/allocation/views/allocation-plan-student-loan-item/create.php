<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanStudentLoanItem */

$this->title = 'Create Allocation Plan Student Loan Item';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Student Loan Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-student-loan-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
