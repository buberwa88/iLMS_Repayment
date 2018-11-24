<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
 
?>
<div class="site-login">

    <div class="row">

        <div  class="col-sm-12">
       <?php 
	 $sqlquest=Yii::$app->db->createCommand('SELECT count(*) FROM `application_cycle` apc join academic_year ac  on apc.`academic_year_id`=ac.`academic_year_id` WHERE application_cycle_status_out_id=2 AND ac.`academic_year_id`=1')->queryScalar();
	if($sqlquest==0){
	?>
            <div style="font-size: 20px"> If you  have already read application guideline  you can
<?php   echo Html::a('Click Here to Register', ['/application/default/loan-apply']); ?>
                . </div>
       <?php 
	}
	else{
    ?>
    <div class="alert alert-warning alert-dismissible">
               
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                 <h2>The Application is Currently Closed.</h2>
              </div>
  <?php } ?>
        </div>
   
</div>
</div>