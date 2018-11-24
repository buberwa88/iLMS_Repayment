<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaField */

$this->title = 'Update Criteria Field: ';
$this->params['breadcrumbs'][] = ['label' => 'Criteria Fields', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->criteria_field_id, 'url' => ['view', 'id' => $model->criteria_field_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="criteria-field-update">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
              <?= Html::a('Return Back', ['index', 'id' => $model->criteria_id], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
 </div>
</div>