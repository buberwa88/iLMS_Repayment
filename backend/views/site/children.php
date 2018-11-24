<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
//$this->title = 'ASSETS  MANAGEMENT SYSTEM';
$this->title = 'Children Home Page';
$this->params['breadcrumbs'][] = $this->title;
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
               <h3 class="box-title">Children Home Page</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <div class="row-fluid">
                   <a href="<?= Yii::$app->urlManager->createUrl(['children/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Users.png') ?></i>
                                        <div>Children</div>

                                </a>
                       <a href="<?= Yii::$app->urlManager->createUrl(['childioffer/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/individualoffering.jpg') ?></i>
                                        <div>Indi Offering</div>

                                </a>
                  <a href="<?= Yii::$app->urlManager->createUrl(['childgoffer/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/generalofferinh.jpg') ?></i>
                                        <div>General Offering</div>

                                </a>
                                <a href="<?= Yii::$app->urlManager->createUrl(['childexpense/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/payment.png') ?></i>
                                        <div>Expense</div>

                                </a>
                  </div>
               
                        <div class="row-fluid">
                         
                    <a href="<?= Yii::$app->urlManager->createUrl(['childpattend/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/jobcardassign.png') ?></i>
                                        <div>Attendance</div>

                                </a>
                               <a href="<?= Yii::$app->urlManager->createUrl(['childgttend/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/jobcardassign.png') ?></i>
                                        <div>General Attendance</div>

                                </a>
                     <a href="<?= Yii::$app->urlManager->createUrl(['childgevent/index','id'=>1])?>" class="icon-btn span2" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Logbook.png') ?></i>
                                        <div>Events</div>

                                </a>        
                      
                      
                              </div>
                             </div>
                   
                </div>     
