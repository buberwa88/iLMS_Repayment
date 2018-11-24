<?php

use yii\helpers\Html;

$this->title = 'Add Grant / Scholarship Institution';
$this->params['breadcrumbs'][] = ['label' => 'Scholarship Institutions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scholarship-student-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form_add_institution', [
        'model' => $model,'institution'=>$institution
    ])
    ?>

</div>
