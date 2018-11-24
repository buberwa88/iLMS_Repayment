<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationFramework */

$this->title = 'Create Verification Framework';
$this->params['breadcrumbs'][] = ['label' => 'Verification Frameworks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-framework-create">
<div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
  </div>
</div>
