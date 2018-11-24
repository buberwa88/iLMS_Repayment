<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting */

$this->title = 'Create Allocation Plan Institution Type Setting';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Institution Type Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-institution-type-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
