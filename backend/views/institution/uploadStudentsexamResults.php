<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\StudentExamResult */

$this->title = 'Upload Student Exam Result';
$this->params['breadcrumbs'][] = ['label' => 'Student Exam Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-exam-result-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <?php
        echo Yii::$app->session->hasFlash('failure') ? Yii::$app->session->getFlash('failure') : '';
        ?>
        <div class="panel-body">
            <p><?php echo Html::a('Download Students Exam. Results Template', ['download-template']) ?></p>
            <?=
            $this->render('_formUploadStudentsExamResults', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>