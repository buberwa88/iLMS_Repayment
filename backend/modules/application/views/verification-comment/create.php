<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationComment */

$this->title = 'Create Verification Comment';
$this->params['breadcrumbs'][] = ['label' => 'Verification Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
