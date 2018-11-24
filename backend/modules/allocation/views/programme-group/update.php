<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ProgrammeGroup */

$this->title = 'Update Programme Group: ' ;
$this->params['breadcrumbs'][] = ['label' => 'Programme Groups', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->programme_group_id, 'url' => ['view', 'id' => $model->programme_group_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="programme-group-update">
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