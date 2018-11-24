<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Programme */

$this->title = 'Update Higher Learning Institution Programme: ';
$this->params['breadcrumbs'][] = ['label' => 'Programme', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => "View Detail", 'url' => ['view', 'id' => $model->programme_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="programme-update">
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