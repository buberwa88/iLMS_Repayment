<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationFeeFactor */

$this->title = 'Update Fee Factor: ' ;
$this->params['breadcrumbs'][] = ['label' => 'Fee Factors', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->allocation_fee_factor_id, 'url' => ['view', 'id' => $model->allocation_fee_factor_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-fee-factor-update">
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