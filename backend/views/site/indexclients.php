<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
 //$this->title = 'Insurance';
 $this->title = 'Account Home';
 $this->params['breadcrumbs'][] = $this->title;
?>
 
<div class="portlet box green">
                <div class="portlet-title">
                        <h4><i class="ace-icon fa fa-home home-icon"></i>Home</h4>
                </div>
                <div class="portlet-body">
                    
             <div class="row-fluid">
                   <a href="<?= Yii::$app->urlManager->createUrl(['customer/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Clients.png') ?></i>
                                        <div>Clients</div>

                                </a>
                 
                            <a href="<?= Yii::$app->urlManager->createUrl(['card/index1','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/transaction.png') ?></i>
                                        <div>Compute Premium</div>

                                </a>
               
                            
                              
                             
                              <a href="<?= Yii::$app->urlManager->createUrl(['premium/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/certf.png') ?></i>
                                        <div>Issues Certificate</div>

                                </a>
                          
                        
                     
                              </div>
                        <div class="row-fluid">
                                  <a href="<?= Yii::$app->urlManager->createUrl(['certificate/index1','id'=>9])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/certf.png') ?></i>
                                        <div>Certificate</div>

                                </a>
                              <a href="<?= Yii::$app->urlManager->createUrl(['certificate/indexc','id'=>9])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/cert_expire.png') ?></i>
                                        <div>Expired Certificate</div>

                                </a>
                              
                           
                        <a href="<?= Yii::$app->urlManager->createUrl(['claims/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Complain.png') ?></i>
                                        <div>Register Claims</div>

                                </a>
                 
                              </div>
                             </div>
                   
                </div>
   </div>
     

      
      
      
      

