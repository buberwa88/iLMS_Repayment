<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantAssociate */

$this->title = "Update Guarantor's Details: ";
$this->params['breadcrumbs'][] = ['label' => 'my application', 'url' => ['default/my-application-index']];
$this->params['breadcrumbs'][] = ['label' => "Guarantor's details", 'url' => ['guarantor-view', 'id' => $model->applicant_associate_id]];
$this->params['breadcrumbs'][] = 'Update';
$applicant_category=$modelApplication->applicant_category_id>0?$modelApplication->applicantCategory->applicant_category:"";

?>
<div class="applicant-associate-update">
<div class="panel panel-info">
        <div class="panel-heading">
          <?=$modelApplication->applicant_category_id==2||$modelApplication->applicant_category_id==4?"Step 8 ":"Step 9"?> : <?= Html::encode($this->title) ?><label class="pull-right" style="font-size:16px"><?=$modelApplication->loanee_category." ".$applicant_category;?></label>
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
