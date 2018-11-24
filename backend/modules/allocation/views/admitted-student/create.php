<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmittedStudent */

$this->title = 'Create Admitted Student';
$this->params['breadcrumbs'][] = ['label' => 'Admitted Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admitted-student-create">
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