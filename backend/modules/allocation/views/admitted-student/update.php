<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmittedStudent */

$this->title = 'Update Admitted Student: ';
$this->params['breadcrumbs'][] = ['label' => 'Admitted Students', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' =>"View Detail", 'url' => ['view', 'id' => $model->admitted_student_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admitted-student-update">
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