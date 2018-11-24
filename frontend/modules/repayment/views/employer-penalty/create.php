<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenalty */

$this->title = 'Create Employer Penalty';
$this->params['breadcrumbs'][] = ['label' => 'Employer Penalties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-penalty-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
