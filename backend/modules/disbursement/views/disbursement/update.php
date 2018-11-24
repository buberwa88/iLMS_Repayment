<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\Disbursement */

$this->title = 'Update Disbursement: ';
$this->params['breadcrumbs'][] = ['label' => 'Disbursements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->disbursement_id, 'url' => ['view', 'id' => $model->disbursement_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-update">
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