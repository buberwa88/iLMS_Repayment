<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementSetting */

$this->title = 'Create Disbursement Setting';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-setting-create">
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