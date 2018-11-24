<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\AttachmentDefinition */

$this->title = 'Update Attachment Definition: ' . $model->attachment_definition_id;
$this->params['breadcrumbs'][] = ['label' => 'Attachment Definitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->attachment_definition_id, 'url' => ['view', 'id' => $model->attachment_definition_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="attachment-definition-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
