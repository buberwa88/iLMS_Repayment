<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationFramework */

$this->title = $model->verification_framework_id;
$this->params['breadcrumbs'][] = ['label' => 'Verification Frameworks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-framework-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->verification_framework_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->verification_framework_id], [
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
            'verification_framework_id',
            'verification_framework_title',
            'verification_framework_desc',
            'verification_framework_stage',
            'created_at',
            'created_by',
            'confirmed_by',
            'confirmed_at',
            'is_active',
        ],
    ]) ?>

</div>
