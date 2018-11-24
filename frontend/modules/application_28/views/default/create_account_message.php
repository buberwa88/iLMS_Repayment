<?php
$ACreatedMessage = Yii::$app->session->get('account_created');
Yii::$app->session->set('account_created', NULL);
?>

<!--<div class="col-xs-6">-->
   <div class="alert alert-success" role="alert">

  <span class="glyphicon glyphicon-ok"></span>
 Success!An email has been sent to <?= $ACreatedMessage['email'] ?>, please login into your email account to activate your admission account. If you don't see the email, please check it in the Spam or Junk folder. 
 
</div> 
<?php echo \kartik\helpers\Html::a('[Go Back]',''); ?>
<!--    <p>An email has been sent to <?= $ACreatedMessage['email'] ?>, please login to activate the created account.</p>-->
<!--    <p><?php //echo $ACreatedMessage['activation_link'] ?></p>-->
    <?php
//     echo yii\helpers\Html::a('Home', ['/site/login']);
//     
//     echo yii\helpers\Html::a('Login', ['/site/login','activeTab'=>'login_tab_id'], ['style'=>'margin-left: 40px;']);
//     ?>
<!--</div>-->
<!--<div  class="col-sm-6">
    
</div>-->