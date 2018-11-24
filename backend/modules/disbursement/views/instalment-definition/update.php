<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\InstalmentDefinition */

$this->title = 'Update Instalment: ';
$this->params['breadcrumbs'][] = ['label' => 'Instalment ', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->instalment_definition_id, 'url' => ['view', 'id' => $model->instalment_definition_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="instalment-definition-update">
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