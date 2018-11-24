<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Education $model
 */

$this->title = 'Update A-level/College Education Details';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = ['label' => 'View ALevel/College Education', 'url' => ['/application/education/alevel-view']];
$this->params['breadcrumbs'][] = $this->title;
$applicant_category=$modelApplication->applicant_category_id>0?$modelApplication->applicantCategory->applicant_category:"";

?>
<div class="education-create">
       <div class="panel panel-info">
        <div class="panel-heading">
     Step 6 : <?= Html::encode($this->title) ?><label class="pull-right" style="font-size:16px"><?=$modelApplication->loanee_category." ".$applicant_category;?></label>
        </div>
        <div class="panel-body">
    <?= $this->render('_alevel_form', [
        'model' => $model,
        'modelApplication'=> $modelApplication
    ]) ?>

</div>
       </div>
</div>