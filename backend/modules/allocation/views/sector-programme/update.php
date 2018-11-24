<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\SectorProgramme */

$this->title = 'Update Sector Programme: ' ;
$this->params['breadcrumbs'][] = ['label' => 'Sector Programme', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>'View Detail', 'url' => ['view', 'id' => $model->sector_programme_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sector-programme-update">
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