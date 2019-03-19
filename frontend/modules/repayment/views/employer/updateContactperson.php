<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = "Update Information";
$this->params['breadcrumbs'][] = ['label' => 'Employer', 'url' => ['view','id'=>$employer_id]];
//$this->params['breadcrumbs'][] = ['label' => $employerModel->employer_id, 'url' => ['view', 'id' => $employerModel->employer_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-update">
<div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">


    <?= $this->render('_form_updateContactPerson', [
        'model' => $model,'employer_id'=>$employer_id
    ]) ?>

</div>
    </div>
</div>
