 
<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */

//$this->title = $model->allocation_batch_id;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Allocation Batch'), 'url' => ['/disbursement/default/allocation-batch']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-batch-view">
 
    <div class="panel panel-info">
                        <div class="panel-heading">
                     
                        </div>
                        <div class="panel-body">
  
    <p>
   <?= Html::a('Click to Award Loan for Freshers', ['award-loanfresher', 'status' =>1], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Are you sure you want to award Loan ?',
                'method' => 'post',
            ],
        ]) ?>
      <?= Html::a('Click to Award Loan for Continuous', ['award-loanfresher', 'status' =>2], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to award Loan ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
                        </div>
    </div>
</div>