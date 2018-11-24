<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\StudentExamResult */

$this->title = 'Register Student Exam Result';
$this->params['breadcrumbs'][] = ['label' => 'Student Exam Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-exam-result-create">
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