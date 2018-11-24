<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationComment */

$this->title = 'Update Verification Comment';
$this->params['breadcrumbs'][] = ['label' => 'Verification Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->verification_comment_id, 'url' => ['view', 'id' => $model->verification_comment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="verification-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

</div>
