<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Programme */

$this->title = 'Clone Allocaton Framework Configuration';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Framework', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) . ' #: <b>' . $model->allocation_plan_number . ', ' . $model->allocation_plan_title . '</b>'; ?>
        </div>

        <?php if (Yii::$app->session->hasFlash('failure')) { ?>
            <div class="alert alert alert-warning" role="alert" style="padding: 5px;margin: 1%;">
                <?php echo Yii::$app->session->getFlash('failure'); ?>
            </div>
        <?php } ?>

        <div class="panel-body">
            <?php
            echo $this->render('_form_clone_plan', [
                'model' => $model, 'model_clone' => $model_clone
            ]);
            ?>
        </div>
    </div>
</div>