<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationReverse */

$this->title = 'Create Application Reverse';
$this->params['breadcrumbs'][] = ['label' => 'Application Reverses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-reverse-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
