<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ProgrammeFee */

$this->title = 'Update Programme Cost: ';
$this->params['breadcrumbs'][] = ['label' => 'Programme Cost', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => "View Detail", 'url' => ['view', 'id' => $model->programme_fee_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="programme-fee-update">
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