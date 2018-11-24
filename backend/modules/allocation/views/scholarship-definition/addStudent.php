<?php

use yii\helpers\Html;

$this->title = 'Add Grant / Scholarship Student';
$this->params['breadcrumbs'][] = ['label' => 'Scholarship Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scholarship-student-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form_add_student', [
        'model' => $model,'student'=>$student
    ])
    ?>

</div>
