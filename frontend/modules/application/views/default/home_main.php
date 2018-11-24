<style>
    .body-text{
       color:#363535;
       margin:0 0;
       font-size: 1.1em; 
    }  
 </style>

<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;

$this->title = 'HESLB Loan Repayment System';
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="home-page">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
      

<?php
$countAllocation=0;
if(false ){
  $CreateAccountTabView = $this->render('applications_closed',[
             'model'=>$model,
             'modelInst'=>$model,
           ]);  
} else {

if(Yii::$app->session->get('account_created') !== NULL){
  $CreateAccountTabView = $this->render('create_account_message'); 
} else {
 
}
}

echo TabsX::widget([
    'items' => [
        [
         'label'=>'Home',
         'content'=>$this->render('home'),
         'id'=>'home_page_contents_id',
         'active'=>($activeTab == 'home_page'),
		 'visible'=>$countAllocation=='23',
        ],
		
        [
          'label'=>'Instructions',
          'content'=>$this->render('how_to_apply'),
          'id'=>'how_to_apply_id',
          'active'=>($activeTab == 'how_to_apply'),
		  'visible'=>$countAllocation=='23',
        ],
        [
           'label'=>'Register',
           'content'=>$this->render('register'),
           'id'=>'create_account_tab_id',
           'active'=>($activeTab == 'register'),
		   'visible'=>$countAllocation=='23',
        ],
		
        [
           'label'=>'Login',
           'content'=>$this->render('login_all', [
                'model' => $model,
            ]),
         'active'=>'login_tab_id',
		 //'active'=>($activeTab == 'login_tab_id'),
         'id'=>'login_tab_id',
         
        ],
		
		
		[
           'label'=>'Register',
           'content'=>$this->render('repayment_register'),
           'id'=>'repayment_register_tab_id',
           'active'=>($activeTab == 'repayment_register'),
        ],
		
  
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => false,
    'encodeLabels' => false
]);

?>
        </div>
    </div>
</div>
