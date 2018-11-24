<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Templates */

$this->title = 'Create Template';
$this->params['breadcrumbs'][] = ['label' => 'Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="templates-create">

     <div class="panel-heading">
       <?= Html::encode($this->title) ?>
     </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

