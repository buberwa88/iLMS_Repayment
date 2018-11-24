<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationFramework */

$this->title = 'Confirm Verification Framework';
$this->params['breadcrumbs'][] = ['label' => 'Verification Frameworks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->verification_framework_id, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="verification-framework-update">

  <div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <?= $this->render('_form_confirm', [
        'model' => $model,
    ]) ?>

</div>
  </div>
</div>
