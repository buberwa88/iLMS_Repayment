<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title ="View Applicant Details";
$this->params['breadcrumbs'][] = ['label' => 'List of Applicant', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
  function check_status() {
      //form-group field-user-verifycode
   document.getElementById("hidden").style.display = "none";
   document.getElementById("loader").style.display = "block";
    }
</script>
<div class="user-view">
<div class="panel panel-info">
        <div class="panel-heading">
         

        </div>
        <div class="panel-body">
     <p id="hidden">
        <?= Html::a('Reset Applicant Password', ['reset-password', 'id' => $model->user_id], ['class' => 'btn btn-primary','onclick'=>'return  check_status()']) ?>
        <?= Html::a('Generate master password', ['master-password', 'id' => $model->user_id], ['class' => 'btn btn-primary','onclick'=>'return  check_status()']) ?> 
    </p>
      <center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>


        </div>
</div>
</div>
