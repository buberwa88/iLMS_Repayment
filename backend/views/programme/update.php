<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Programme */

$this->title = 'Update Programme: ' . $model->programme_id;
$this->params['breadcrumbs'][] = ['label' => 'Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->programme_id, 'url' => ['view', 'id' => $model->programme_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="programme-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
