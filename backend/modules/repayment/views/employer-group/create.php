<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerGroup */

$this->title = 'Create Employer Group';
$this->params['breadcrumbs'][] = ['label' => 'Employer Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
