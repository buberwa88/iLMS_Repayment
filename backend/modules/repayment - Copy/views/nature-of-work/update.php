<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\NatureOfWork */

$this->title = 'Update Sector';
$this->params['breadcrumbs'][] = ['label' => 'Sector', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->description, 'url' => ['view', 'id' => $model->nature_of_work_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nature-of-work-update">
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
