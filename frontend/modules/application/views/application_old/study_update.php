<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Education $model
 */

$this->title = 'Update Specify Applicant Category';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = ['label' => 'View Details', 'url' => ['/application/application/study-view']];
$this->params['breadcrumbs'][] = $this->title;
$applicant_category=$model->applicant_category_id>0?$model->applicantCategory->applicant_category:"";

?>
<div class="education-create">
      <div class="panel panel-info">
        <div class="panel-heading">
        Step 3 : <?= Html::encode($this->title) ?><label class="pull-right" style="font-size:16px"><?=$model->loanee_category." ".$applicant_category;?></label>
        </div>
        <div class="panel-body">
    <?= $this->render('_study_level', [
        'model' => $model,
    ]) ?>

</div>
      </div>
</div>