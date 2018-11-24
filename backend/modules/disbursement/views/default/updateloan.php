<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementBatch */

$this->title = 'Create Disbursement';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-batch-create">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_loaneeform', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
