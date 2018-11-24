<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LoanItemPriority */

$this->title = 'Update Loan Item Priority: ';
$this->params['breadcrumbs'][] = ['label' => 'Loan Item Priorities', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->loan_item_priority_id, 'url' => ['view', 'id' => $model->loan_item_priority_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-item-priority-update">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>