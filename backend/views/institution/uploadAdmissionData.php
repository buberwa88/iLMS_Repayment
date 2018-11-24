<?php

use backend\modules\allocation\models\AcademicYear;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmissionBatch */

$this->title = 'Import/Upload Admission';
$this->params['breadcrumbs'][] = ['label' => 'Student Admission ', 'url' => ['institution/student-admissions']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admission-batch-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title . ' for Academci Year ' . AcademicYear::getCurrentYearName()); ?>
        </div>
        <div class="panel-body">
            <?php if (Yii::$app->session->hasFlash('success')) { ?>
                <div class="alert alert alert-success" role="alert" style="padding: 5px;">
                    <?php echo Yii::$app->session->getFlash('success'); ?>
                </div>
            <?php }
            ?>
            <?php if (Yii::$app->session->hasFlash('failure')) { ?>
                <div class="alert alert alert-warning" role="alert" style="padding: 5px;">
                    <?php echo Yii::$app->session->getFlash('failure'); ?>
                </div>
            <?php }
            ?>
            <p><?php echo Html::a('Download Students Admission Template', ['download-template']) ?></p>

            <?=
            $this->render('_form_upload_admission', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
