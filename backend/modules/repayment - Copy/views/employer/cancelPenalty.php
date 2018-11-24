<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenalty */

$this->title = 'Cancel Employer Penalty';
//$this->params['breadcrumbs'][] = ['label' => 'Employer Penalties', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->employer_penalty_id, 'url' => ['view', 'id' => $model->employer_penalty_id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-penalty-update">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
		</div>
        <div class="panel-body">
    <?= $this->render('_formCancelEmployerPenalty', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
