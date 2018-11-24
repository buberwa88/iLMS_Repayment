<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaQuestionAnswer */

$this->title = $model->criteria_question_answer_id;
$this->params['breadcrumbs'][] = ['label' => 'Criteria Question Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-question-answer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->criteria_question_answer_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->criteria_question_answer_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'criteria_question_answer_id',
            'criteria_question_id',
            'qresponse_source_id',
            'response_id',
            'value',
        ],
    ]) ?>

</div>
