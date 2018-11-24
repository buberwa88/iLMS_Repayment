<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationCustomCriteria */

$this->title = 'Create Verification Custom Criteria';
$this->params['breadcrumbs'][] = ['label' => 'Verification Custom Criterias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-custom-criteria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
