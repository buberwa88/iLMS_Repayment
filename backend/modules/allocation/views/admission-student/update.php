<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmissionStudent */

$this->title = 'Update Admission Student: ' . $model->admission_student_id;
$this->params['breadcrumbs'][] = ['label' => 'Admission Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->admission_student_id, 'url' => ['view', 'id' => $model->admission_student_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admission-student-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
