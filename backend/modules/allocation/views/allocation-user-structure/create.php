<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationUserStructure */

$this->title = 'Assign Allocation Staff to Allocation Structure';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Staff Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-user-structure-create">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title); ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>