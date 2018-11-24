<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipProgramme */

$this->title = 'Add Scholarship StudyLevel';
$this->params['breadcrumbs'][] = ['label' => 'Scholarship Study Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scholarship-programme-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_add_study_level', [
        'model' => $model,'study_level'=>$study_level
    ]) ?>

</div>
