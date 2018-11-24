<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = 'Select Salary Source';
?>
<div class="employer-update">
<div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">


    <?= $this->render('_formUpdateSalarysource', [
        'model1' => $model1,'model2' => $model2,
    ]) ?>

</div>
    </div>
</div>
