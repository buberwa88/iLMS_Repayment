<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationStructure */

$this->title = 'Create Allocation Structure';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-structure-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
