<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Create Staff';
$this->params['breadcrumbs'][] = ['label' => 'Staffs', 'url' => ['add-user']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
<div class="panel panel-info">
    <div class="panel-heading">              
        <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <?= $this->render('_form_add_user', [
        'model' => $model,
    ]) ?>

</div>
  </div>
</div>
