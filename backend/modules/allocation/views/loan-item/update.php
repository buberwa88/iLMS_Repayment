<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LoanItem */

$this->title = 'Update Loan Item: ';
$this->params['breadcrumbs'][] = ['label' => 'Loan Items', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => 'View Detail', 'url' => ['view', 'id' => $model->loan_item_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-item-update">
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
