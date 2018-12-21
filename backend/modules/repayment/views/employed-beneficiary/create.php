<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = 'Add New Employee'."( Employer: ".\backend\modules\repayment\models\Employer::getEmployerDetails($employerID)->employer_name.")";
$this->params['breadcrumbs'][] = ['label' => 'Employer', 'url' => ['employer/view','id'=>$employerID]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-create">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_formAdditionalEmployee', [
        'model' => $model,'employerID'=>$employerID
    ]) ?>

</div>
    </div>
</div>
