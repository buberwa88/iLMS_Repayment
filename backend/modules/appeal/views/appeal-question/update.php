<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealQuestion */

$this->title = 'Update Appeal Question: ' . ' ' . $model->appeal_question_id;
$this->params['breadcrumbs'][] = ['label' => 'Appeal Question', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->appeal_question_id, 'url' => ['view', 'id' => $model->appeal_question_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="appeal-question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
