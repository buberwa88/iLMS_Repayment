<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\Applicant */

$this->title = 'HESLB Online Loans Application';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-create">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
      
    <?= $this->render('_apply_for_loan', [
        'model' => $model,
        'modelall' => $modelall,
    ]) ?>

</div>
  </div>
</div>