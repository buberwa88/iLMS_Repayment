<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgCnumber */

$this->title = 'Update Gepg Cnumber: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gepg Cnumbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gepg-cnumber-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
