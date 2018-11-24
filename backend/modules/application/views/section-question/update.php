<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\SectionQuestion $model
 */

$this->title = 'Update Section Question: ' . ' ' . $model->section_question_id;
$this->params['breadcrumbs'][] = ['label' => 'Section Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->section_question_id, 'url' => ['view', 'id' => $model->section_question_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="section-question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
