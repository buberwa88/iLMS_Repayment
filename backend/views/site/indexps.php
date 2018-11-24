<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Insurance';
//$this->title = 'About';
//$this->params['breadcrumbs'][] = $this->title;
?>
 
<div class="portlet box green">
                <div class="portlet-title">
                        <h4><i class="ace-icon fa fa-home home-icon"></i>Home</h4>
                </div>
                <div class="portlet-body">
                    
             <div class="row-fluid">
                   <a href="<?= Yii::$app->urlManager->createUrl(['staff/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Report2.png') ?></i>
                                        <div>Body Type</div>

                                </a>
               
                            
                              
                             
                              <a href="<?= Yii::$app->urlManager->createUrl(['insurer/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/role.png') ?></i>
                                        <div>Class Type</div>

                                </a>
                           
                       
               <a href="<?= Yii::$app->urlManager->createUrl(['usedtype/index','id'=>9])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Document.png') ?></i>
                                        <div>Usage Type</div>

                                </a>
                   <a href="<?= Yii::$app->urlManager->createUrl(['covertype/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Report2.png') ?></i>
                                        <div>Cover Type</div>

                                </a>
                      
                              </div>
                             </div>
                   
                </div>
   </div>
     

      
      
      
      


