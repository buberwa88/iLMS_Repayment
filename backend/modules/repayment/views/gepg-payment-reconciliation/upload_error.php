<?php

use yii\helpers\Html;
$this->title = 'Upload Payments Reconciliation';
?> 
<div class="employed-beneficiary-create">

<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">   
      <?= Html::a('RE-UPLOAD', ['upload-payment-recon'], ['class' => 'btn btn-success']) ?>


</div>
    </div>
</div>