<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Templates */

$this->title = 'Update Templates: ' . $model->template_name;
$this->params['breadcrumbs'][] = ['label' => 'Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="templates-update">

       <div class="panel-heading">
       <?= Html::encode($this->title) ?>
     </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

