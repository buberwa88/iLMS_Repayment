<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
$this->title = 'Employer Registration';
//$this->title = $model->employer_id;
//$this->params['breadcrumbs'][] = ['label' => 'Employers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-view">
    <div class="panel panel-info">
        <div class="panel-body">
		<?php if($status !=2 && $status !=3 && $status !=4){ ?>
            <font size="4">
Congratulations!
<br/>
You have created an account on the HESLB, You will get notification though EMAIL after your account being successful verified by HESLB, thank you!.
</font>
<?php } ?>
<?php if($status==2){ ?>
            <font size="4" color="red">
Sorry!
<br/>
The Employer exist, kindly login or contact HESLB. 
</font>
<?php } ?>
<?php if($status==3){ ?>
            <font size="4">
<i><center>Complete Registration by entering the verification code sent into contact person's email address.</center></i>
</font><br/>
<?= $this->render('_formEmployerVerificationCode', [
                'model' => $model,
                ])            
                    ?>
<?php } ?>

<?php if($status==4){ ?>
            <font size="4">
Complete Registration!
<br/>
Kindly visit your contact person's email address to confirm your HESLB account.
</font>
<?php } ?>
        </div>
    </div>
</div>
