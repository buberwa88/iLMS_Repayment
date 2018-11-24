<?php 
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = 'Recover Password';
 ?>
<div class="beneficiary-confirm-details">

<div class="panel panel-info">
        <div class="panel-body">

    <p>
	<?php if($id ==0){ ?>
	<center>
	No record found
	</center>
	<?php } ?>
    </p>
	<?php if($id !=0){ ?>
	<?php
echo $sms;
	?>
	<?php
}else{
	?>
	<center>
	<p>
	<center>
		<?php  if($id ==0){?>
        <?= Html::a("BACK TO LOGIN&nbsp;&nbsp;<span class='label label-warning'></span>", ['/site/login'], ['class' => 'btn btn-warning'])?>
		<?php } ?>
		</center>
	</p>
	<center>
	<?php } ?>
	</div>
    </div>
	
</div>