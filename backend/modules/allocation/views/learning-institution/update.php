<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LearningInstitution */

$this->title = 'Update Learning Institution: ';
$this->params['breadcrumbs'][] = ['label' => 'Learning Institutions', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => "View Detail", 'url' => ['view', 'id' => $model->learning_institution_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="learning-institution-update">
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
