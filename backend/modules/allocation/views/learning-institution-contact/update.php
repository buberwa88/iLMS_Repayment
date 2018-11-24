<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LearningInstitutionContact */

$this->title = 'Update Learning Institution Contact: ';
$this->params['breadcrumbs'][] = ['label' => 'Learning Institution Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->learning_institution_id, 'url' => ['view', 'id' => $model->learning_institution_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="learning-institution-contact-update">
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
