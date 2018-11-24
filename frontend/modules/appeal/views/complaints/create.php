<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\Complaint */

$this->title = 'Create Complaint';
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="complaint-index">
    <div class="panel panel-info">
        
        <div class="panel-heading">
            <strong><?= Html::encode("Complaint") ?></strong>
        </div>

        <div class="complaint-create">
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>