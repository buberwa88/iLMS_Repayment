<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Create New Contact Person';
$this->params['breadcrumbs'][] = ['label' => 'Contact Person', 'url' => ['view','id'=>$employer_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
<div class="panel panel-info">
    <div class="panel-heading">              
        <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <?= $this->render('_form_addContactPerson', [
        'model' => $model,'employer_id'=>$employer_id,
    ]) ?>

</div>
  </div>
</div>
