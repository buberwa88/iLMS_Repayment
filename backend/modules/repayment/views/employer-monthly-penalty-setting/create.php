<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerMonthlyPenaltySetting */

$this->title = 'Create Employer Monthly Penalty';
$this->params['breadcrumbs'][] = ['label' => 'Employer Monthly Penalty', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-monthly-penalty-setting-create">
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
