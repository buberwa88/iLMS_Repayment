    <?php
    use yii\helpers\Html;
    $this->title = 'Self Registration Success';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
 <div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
 
      <h3>You have complete <strong>registration stage</strong> ,You still have other <strong>stages </strong> to complete application !.</h3>          
      <h4 >Your names are ::<strong><?=$name_fully?></strong> </h4>
       <h4 >Your login Username is:<b><label class="btn-danger" style="padding:0px 10px;"><strong><?=$username?></strong></label></b></h4>
       <h4><font color='red'>Remember the password you entered is <strong>CASE SENSITIVE</strong> eg Capital letter should be typed as capital letter and a small letter as such.</font></h4>
       <h4><font color='green'>Note down both <strong>username</strong> and initial <strong>password</strong> for future use but keep them <strong>secret .</strong></font><?= Html::a('click here to login ', ['/application/default/home-page','activeTab'=>'login_tab_id']) ?></h4>
 
   
 <p>  <?= Html::a('Click to return home', ['/application/default/home-page'], ['class' => 'btn btn-success']) ?></p>
 

</div>
        </div>
</div>