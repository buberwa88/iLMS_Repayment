<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
//$this->title = 'Insurance';
 $this->title = 'Client Home';
 $this->params['breadcrumbs'][] = $this->title;
?>
 
<div class="portlet box green">
                <div class="portlet-title">
                        <h4><i class="ace-icon fa fa-home home-icon"></i>Home</h4>
                </div>
                <div class="portlet-body">
                    
             <div class="row-fluid">
                   <a href="<?= Yii::$app->urlManager->createUrl(['staff/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/company_staff.png') ?></i>
                                        <div>Staffs</div>

                                </a>
               
                            
                              
                             
                              <a href="<?= Yii::$app->urlManager->createUrl(['insurer/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/oper.png') ?></i>
                                        <div>Insurer</div>

                                </a>
                               <a href="<?= Yii::$app->urlManager->createUrl(['modeltype/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/bodytype.png') ?></i>
                                        <div>Body Type</div>

                                </a>
               
                            
                              
                             
                              <a href="<?= Yii::$app->urlManager->createUrl(['bimacategory/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/CauseList.png') ?></i>
                                        <div>Class Type</div>

                                </a>
                           
             
                      
                              </div>
                        <div class="row-fluid">
                                      
               <a href="<?= Yii::$app->urlManager->createUrl(['usedtype/index','id'=>9])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Library21.png') ?></i>
                                        <div>Usage Type</div>

                                </a>
                   <a href="<?= Yii::$app->urlManager->createUrl(['covertype/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/cert_expire12.png') ?></i>
                                        <div>Cover Type</div>

                                </a>
               <a href="<?= Yii::$app->urlManager->createUrl(['organization/view','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/institute1.png') ?></i>
                                        <div>Organization Details</div>

                                </a>
                   <a href="<?= Yii::$app->urlManager->createUrl(['branch/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Project4.png') ?></i>
                                        <div>Branch</div>

                                </a>
                      
                              </div>
                             </div>
                   
                </div>
   </div>
     

      
      
      
      


