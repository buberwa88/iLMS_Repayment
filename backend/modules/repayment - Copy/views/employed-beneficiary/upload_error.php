<?php

use yii\helpers\Html;
$this->title = 'Upload Employees Loan Beneficiaries';
?> 
<div class="employed-beneficiary-create">

<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">   

      <?= Html::a('BACK TO THE LIST', ['index'], ['class' => 'btn btn-success']) ?>
      <?= Html::a('RE-UPLOAD', ['upload-general'], ['class' => 'btn btn-success']) ?>


</div>
    </div>
</div>