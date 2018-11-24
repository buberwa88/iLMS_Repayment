<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationReverse */

$this->title = 'Update Application Reverse: ' . $model->application_reverse_id;
$this->params['breadcrumbs'][] = ['label' => 'Application Reverses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->application_reverse_id, 'url' => ['view', 'id' => $model->application_reverse_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="application-reverse-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
