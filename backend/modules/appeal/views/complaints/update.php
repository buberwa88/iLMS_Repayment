<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\Complaint */

$this->title = 'Update Complaint';
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->complaint_id, 'url' => ['view', 'id' => $model->complaint_id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="complaint-update">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
    
    
        <div class="panel-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
