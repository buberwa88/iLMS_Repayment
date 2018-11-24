<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ProgrammeCategory */

$this->title = 'Update Programme Category: ';
$this->params['breadcrumbs'][] = ['label' => 'Programme Categories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->programme_category_id, 'url' => ['view', 'id' => $model->programme_category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="programme-category-update">
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
