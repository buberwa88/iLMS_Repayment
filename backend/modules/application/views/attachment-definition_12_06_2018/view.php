<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\AttachmentDefinition */

$this->title = $model->attachment_definition_id;
$this->params['breadcrumbs'][] = ['label' => 'Attachment Definitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attachment-definition-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->attachment_definition_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->attachment_definition_id], [
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
            'attachment_definition_id',
            'attachment_desc',
            'max_size_MB',
            'require_verification',
            'verification_prompt',
            'is_active',
        ],
    ]) ?>

</div>
