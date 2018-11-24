<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantAssociate */

$this->title = 'Update Guarantor Details: ';
$this->params['breadcrumbs'][] = ['label' => 'my application', 'url' => ['default/my-application-index']];
$this->params['breadcrumbs'][] = ['label' => "Guarantor details", 'url' => ['guarantor-view', 'id' => $model->applicant_associate_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="applicant-associate-update">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form_guarantor', [
                'model' => $model,
                'modelApplication'=>$modelApplication,
            ])
            ?>

        </div>
    </div>
</div>
