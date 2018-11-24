<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealCategory */

$this->title = 'Update Appeal Category: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Appeal Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->appeal_category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="appeal-category-update">
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

