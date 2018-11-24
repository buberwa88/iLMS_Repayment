<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationCommentGroup */

$this->title = $model->verification_comment_group_id;
$this->params['breadcrumbs'][] = ['label' => 'Verification Comment Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-comment-group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->verification_comment_group_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->verification_comment_group_id], [
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
            'verification_comment_group_id',
            'comment_group',
            'created_by',
            'created_at',
        ],
    ]) ?>

</div>
