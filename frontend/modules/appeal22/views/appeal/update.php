<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\Appeal */

$this->title = 'Update Appeal: ' . $model->appeal_id;
$this->params['breadcrumbs'][] = ['label' => 'Appeals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->appeal_id, 'url' => ['view', 'id' => $model->appeal_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="appeal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
