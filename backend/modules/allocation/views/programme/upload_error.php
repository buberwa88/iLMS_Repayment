<?php

use yii\helpers\Html;
$this->title = 'Upload Programmes';
?> 
<div class="employed-beneficiary-create">

<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">   
      <?= Html::a('RE-UPLOAD', ['bulk-upload'], ['class' => 'btn btn-success']) ?>


</div>
    </div>
</div>