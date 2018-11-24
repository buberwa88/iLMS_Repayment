<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementStructure */

$this->title = 'Update Disbursement Structure: ' ;
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Structures', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->disbursement_structure_id, 'url' => ['view', 'id' => $model->disbursement_structure_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-structure-update">
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
