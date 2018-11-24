<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationAssignment */

$this->title = 'Assign';
$this->params['breadcrumbs'][] = ['label' => 'Verifications Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-assignment-create">
<div class="panel panel-info">
    <div class="panel-heading">              
        <?php
//        $results=backend\modules\application\models\VerificationAssignment::getTotalApplicationByCategory();
//        echo "Total: Diploma => ".number_format($results->Diploma).", "." Bachelor => ".number_format($results->Bachelor).", "." Masters => ".number_format($results->Masters).", "." Postgraduate Diploma => ".number_format($results->Postgraduate_Diploma).", "." PhD => ".number_format($results->PhD);
        echo $this->render('_details');
        ?>
        <br/>
        <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
  </div>
</div>
