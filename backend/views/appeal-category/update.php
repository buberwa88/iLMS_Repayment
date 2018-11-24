<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealCategory */

$this->title = 'Update Appeal Category: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Appeal Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->appeal_category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="appeal-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
