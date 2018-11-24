<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AcademicYear */

$this->title = 'Create Academic Year';
$this->params['breadcrumbs'][] = ['label' => 'Academic Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academic-year-create">
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