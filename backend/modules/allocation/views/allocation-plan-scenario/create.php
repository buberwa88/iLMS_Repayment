<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationFrameworkScenario */

$this->title = 'Create Allocation Framework Scenario';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Framework Scenarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-framework-scenario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
