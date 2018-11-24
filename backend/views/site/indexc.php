<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
 $this->title = 'Account Home';
 $this->params['breadcrumbs'][] = $this->title;
?>
 
<div class="portlet box green">
                <div class="portlet-title">
                        <h4><i class="ace-icon fa fa-home home-icon"></i>Home</h4>
                </div>
                <div class="portlet-body ">
                    
             <div class="row-fluid">
                    <a href="<?= Yii::$app->urlManager->createUrl(['premium/invoiceg','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Invoice1.png') ?></i>
                                        <div>Generate Invoice</div>

                                </a>
                 <a href="<?= Yii::$app->urlManager->createUrl(['invoice/indexp','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Invoice2.png') ?></i>
                                        <div>Pending Invoice</div>

                                </a>
                            
                                <a href="<?= Yii::$app->urlManager->createUrl(['invoicesummary/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Invoice.png') ?></i>
                                        <div>Invoice</div>

                                </a>
                              </div>
                        <div class="row-fluid">
        
                      <a href="<?= Yii::$app->urlManager->createUrl(['accounts/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/glreport.jpg') ?></i>
                                        <div>Account Group</div>

                                </a>
                             <a href="<?= Yii::$app->urlManager->createUrl(['chartmaster/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Accounting2.png') ?></i>
                                        <div>Account Ledger</div>

                                </a>     
                                <a href="<?= Yii::$app->urlManager->createUrl(['transaction/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/transaction12.png') ?></i>
                                        <div>Transaction</div>

                                </a>
               
                              </div>
                             </div>
                   
                </div>
   </div>
     

      
      
      
      


