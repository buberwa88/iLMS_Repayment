<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealQuestion */

$this->title = 'Create Appeal Question';
$this->params['breadcrumbs'][] = ['label' => 'Appeal Question', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appeal-question-create">
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
