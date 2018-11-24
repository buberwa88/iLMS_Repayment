<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ProgrammeCategory */

$this->title = 'Create Programme Category';
$this->params['breadcrumbs'][] = ['label' => 'Programme Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-category-create">
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
