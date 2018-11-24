<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationAssignment */

$this->title = 'Reverse in Bulk';
$this->params['breadcrumbs'][] = ['label' => 'Verifications Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-assignment-create">
<div class="panel panel-info">
    <div class="panel-heading">              
       <?php
        //echo $this->render('_details');
        ?>
        <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">

    <?= $this->render('_form_bulk_reverse', [
        'model' => $model,
    ]) ?>

</div>
  </div>
</div>
