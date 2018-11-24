<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationCommentGroup */

$this->title = 'Update Verification Comment Group';
$this->params['breadcrumbs'][] = ['label' => 'Verification Comment Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->verification_comment_group_id, 'url' => ['view', 'id' => $model->verification_comment_group_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="verification-comment-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
