<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementDependent */

$this->title = 'Update Loan Item Associate: ';
$this->params['breadcrumbs'][] = ['label' => 'Loan Item', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->disbursement_setting2_id, 'url' => ['view', 'id' => $model->disbursement_setting2_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-dependent-update">
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