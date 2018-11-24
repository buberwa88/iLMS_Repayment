<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
//$this->title = 'ASSETS  MANAGEMENT SYSTEM';
//$this->title = 'About';
//$this->params['breadcrumbs'][] = $this->title;
?>
 
 <div class="box box-info">
            <div class="box-header with-border">
               <h3 class="box-title">Home Page</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <div class="row-fluid">
                 <a href="<?= Yii::$app->urlManager->createUrl(['#','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/analytic.png') ?></i>
                                        <div>Dashboard</div>

                                </a>
                              <a href="<?= Yii::$app->urlManager->createUrl(['/application/default','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/jobcardassign.png') ?></i>
                                        <div>Application</div>

                                </a>
                                <a href="<?= Yii::$app->urlManager->createUrl(['/allocation/default','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                          <i><?php echo Html::img('@web/image/Logbook.png') ?></i>
                                        <div>Allocation</div>

                                </a>
                          <a href="<?= Yii::$app->urlManager->createUrl(['/disbursement/default','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/transaction12.png') ?></i>
                                        <div>Disbursement</div>

                                </a>
            </div>
            <div class="row-fluid">
                 <a href="<?= Yii::$app->urlManager->createUrl(['/appeal/default','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Complain.png') ?></i>
                                        <div>Appeal & Complain</div>

                                </a>
                               <a href="<?= Yii::$app->urlManager->createUrl(['/repayment/default','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/transaction.png') ?></i>
                                        <div>Repayment</div>

                                </a>
                               <a href="<?= Yii::$app->urlManager->createUrl(['site/lookup','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Set3.png') ?></i>
                                        <div>Configuration</div>

                                </a>
                              <a href="<?= Yii::$app->urlManager->createUrl(['site/index','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Report.png') ?></i>
                                        <div>Reports</div>

                                </a>
                      
                              </div>
                             </div>
                   
                </div>     
