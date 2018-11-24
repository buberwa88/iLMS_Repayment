<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipDefinition */

$this->title = 'Update Scholarship Definition: ' . $model->scholarship_id;
$this->params['breadcrumbs'][] = ['label' => 'Scholarship Definitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->scholarship_id, 'url' => ['view', 'id' => $model->scholarship_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="scholarship-definition-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
