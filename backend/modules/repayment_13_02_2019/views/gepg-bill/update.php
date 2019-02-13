<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgBill */

$this->title = 'Cancel Bill#: ' . $model->bill_number;
$this->params['breadcrumbs'][] = ['label' => 'Bills', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Cancel';
?>
<div class="gepg-bill-update">
 <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
		<div class="panel-body">
    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

        </div>
    </div>
</div>
