<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerPenaltyCycle */

$this->title = 'Create Employer Penalty Cycle';
$this->params['breadcrumbs'][] = ['label' => 'Employer Penalty Cycles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-penalty-cycle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
