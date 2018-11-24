<?php

use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\Question $model
 */

$this->title = "Update Applicant's Basic Information";
$this->params['breadcrumbs'][] = ['label' => 'View Basic Information', 'url' => ['my-profile']];
$this->params['breadcrumbs'][] = $this->title;
$applicant_category=$modelapp->applicant_category_id>0?$modelapp->applicantCategory->applicant_category:"";

?>
<div class="profile-create">
  <div class="panel panel-info">
        <div class="panel-heading">
       Step 3 : <?= Html::encode($this->title) ?><label class="pull-right" style="font-size:16px"><?=$modelapp->loanee_category." ".$applicant_category;?></label>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_profileform', [
                'model' => $model,
                'modelall' => $modelall,
                'modelapp' => $modelapp
            ])
            ?>

        </div>
    </div>
</div>
