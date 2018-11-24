<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaQuestion */

$this->title = 'Update Criteria Question: ';
$this->params['breadcrumbs'][] = ['label' => 'Criteria Questions', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->criteria_question_id, 'url' => ['view', 'id' => $model->criteria_question_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="criteria-question-update">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
              <?= Html::a('Return Back', ['index', 'id' => $model->criteria_id], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
        'model_criteria_question_answer'=>$model_criteria_question_answer
    ]) ?>

</div>
 </div>
</div>
