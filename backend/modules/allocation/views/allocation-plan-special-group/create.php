<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationFrameworkSpecialGroup */

$this->title = 'Create Allocation Framework Special Group';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Framework Special Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-framework-special-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
