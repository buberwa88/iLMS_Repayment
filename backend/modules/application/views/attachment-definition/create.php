<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\AttachmentDefinition */

$this->title = 'Create Verification Item';
$this->params['breadcrumbs'][] = ['label' => 'Verification Item', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attachment-definition-create">
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
