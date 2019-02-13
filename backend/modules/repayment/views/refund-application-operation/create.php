<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundApplicationOperation */

$this->title = 'Create Refund Application Operation';
$this->params['breadcrumbs'][] = ['label' => 'Refund Application Operations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-application-operation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
