<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaQuestionAnswer */

$this->title = 'Create Criteria Question Answer';
$this->params['breadcrumbs'][] = ['label' => 'Criteria Question Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-question-answer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
