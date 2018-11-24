<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementSetting */

$this->title = 'Update Disbursement Setting: ';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Settings', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->disbursement_setting_id, 'url' => ['view', 'id' => $model->disbursement_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-setting-update">
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
