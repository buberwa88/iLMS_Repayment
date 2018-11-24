<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\AttachmentDefinition */

$this->title = 'Update Verification Item';
$this->params['breadcrumbs'][] = ['label' => 'Verification Item', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->attachment_definition_id, 'url' => ['view', 'id' => $model->attachment_definition_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="attachment-definition-update">
<div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
  </div>
</div>
