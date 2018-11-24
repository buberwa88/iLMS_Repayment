<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaQuestionAnswer */

$this->title = 'Update Criteria Question Answer: ' . $model->criteria_question_answer_id;
$this->params['breadcrumbs'][] = ['label' => 'Criteria Question Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->criteria_question_answer_id, 'url' => ['view', 'id' => $model->criteria_question_answer_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="criteria-question-answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
