<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\FinancialYear */

$this->title = 'Create Financial Year';
$this->params['breadcrumbs'][] = ['label' => 'Financial Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-year-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
