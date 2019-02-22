<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundApplication */

$this->title = 'Create Refund Application';
$this->params['breadcrumbs'][] = ['label' => 'Refund Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-application-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
