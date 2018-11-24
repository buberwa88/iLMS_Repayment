<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AcademicYear */

$this->title = 'Update Academic Year: ';
$this->params['breadcrumbs'][] = ['label' => 'Academic Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->academic_year_id, 'url' => ['view', 'id' => $model->academic_year_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="academic-year-update">
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