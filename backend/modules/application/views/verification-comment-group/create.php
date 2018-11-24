<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationCommentGroup */

$this->title = 'Create Verification Comment Group';
$this->params['breadcrumbs'][] = ['label' => 'Verification Comment Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-comment-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
