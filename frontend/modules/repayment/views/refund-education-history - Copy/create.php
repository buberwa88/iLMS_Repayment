<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundEducationHistory */

$this->title = 'Step 2: Tertiary Education Details';
//$this->params['breadcrumbs'][] = ['label' => 'Refund Education Histories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-education-history-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
