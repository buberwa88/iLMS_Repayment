<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\SectorDefinition */

$this->title = 'Update Sector : ';
$this->params['breadcrumbs'][] = ['label' => 'Sector', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "View Detail", 'url' => ['view', 'id' => $model->sector_definition_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sector-definition-update">
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