<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationFrameworkItem */

$this->title = 'Create Verification Framework Item';
$this->params['breadcrumbs'][] = ['label' => 'Verification Framework Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-framework-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
