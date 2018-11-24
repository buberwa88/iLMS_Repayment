<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaDefinition */

$this->title = 'Update Criteria: ';
$this->params['breadcrumbs'][] = ['label' => 'Criteria', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->criteria_id, 'url' => ['view', 'id' => $model->criteria_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="criteria-definition-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
