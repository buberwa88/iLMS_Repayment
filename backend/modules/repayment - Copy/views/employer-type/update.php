<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerType */

$this->title = 'Update Employer Type: ' . $model->employer_type;
$this->params['breadcrumbs'][] = ['label' => 'Employer Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employer_type, 'url' => ['view', 'id' => $model->employer_type_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-type-update">
 <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

        </div>
    </div>
</div>
