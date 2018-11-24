<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationFrameworkItem */

$this->title = $model->verification_framework_item_id;
$this->params['breadcrumbs'][] = ['label' => 'Verification Framework Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-framework-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->verification_framework_item_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->verification_framework_item_id], [
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
            'verification_framework_item_id',
            'verification_framework_id',
            'attachment_definition_id',
            'attachment_desc',
            'verification_prompt',
            'created_at',
            'created_by',
            'is_active',
        ],
    ]) ?>

</div>
