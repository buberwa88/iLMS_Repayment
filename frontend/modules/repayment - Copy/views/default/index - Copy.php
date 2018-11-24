<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
//$this->title = 'ASSETS  MANAGEMENT SYSTEM';
//$this->title = 'About';
//$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.icon-btn {
    height: 70px;
    width: 50px;
    margin: 10px 0px 10px 0px;
    border: 1px solid #ddd;
    padding: 16px 0px 0px 0px;
    background-color: #fafafa !important;
    background-image: none !important;
    filter: none !important;
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
    display: block !important;
    color: #646464 !important;
    text-shadow: none !important;
    text-align: center;
    cursor: pointer;
    position: relative;
    -webkit-transition: all 0.3s ease !important;
    -moz-transition: all 0.3s ease !important;
    -ms-transition: all 0.3s ease !important;
    -o-transition: all 0.3s ease !important;
    transition: all 0.3s ease !important;
}

</style>
 <div class="box box-info">
            <div class="box-header with-border">
               <h3 class="box-title">Home Page</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <div class="row-fluid">
                 <a href="<?= Yii::$app->urlManager->createUrl(['site/dashboard','id'=>1])?>" class="btn btn-app" style="min-height:180px">
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
                
                               <a href="<?= Yii::$app->urlManager->createUrl(['/repayment/default','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/transaction.png') ?></i>
                                        <div>Repayment</div>

                                </a>
                               <a href="<?= Yii::$app->urlManager->createUrl(['site/lookup','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Set3.png') ?></i>
                                        <div>Look Up</div>

                                </a>
                              <a href="<?= Yii::$app->urlManager->createUrl(['site/index','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Report.png') ?></i>
                                        <div>Reports</div>

                                </a>
                      
                              </div>
                             </div>
                   
                </div>     
