<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
//$this->title = 'ASSETS  MANAGEMENT SYSTEM';
//$this->title = 'About';
$this->title ="People Home Page";
$this->params['breadcrumbs'][] = $this->title;
///$this->params['breadcrumbs'][] = ['label' => '', 'url' => ['index']];
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
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <div class="row-fluid">
                 
                       <a href="<?= Yii::$app->urlManager->createUrl(['pastors/index','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/pastor12.png') ?></i>
                                        <div>Pastor</div>

                                </a>
                   <a href="<?= Yii::$app->urlManager->createUrl(['elder/index','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/pastor.png') ?></i>
                                        <div>Elder</div>

                                </a>
                            
                                <a href="<?= Yii::$app->urlManager->createUrl(['member/index','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/group12.png') ?></i>
                                        <div>Congregation</div>

                                </a>
              
                                <a href="<?= Yii::$app->urlManager->createUrl(['employee/index','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/Clients.png') ?></i>
                                         <div>Volunteer</div>

                                </a>
                    <a href="<?= Yii::$app->urlManager->createUrl(['wedding/index','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/wedding.png') ?></i>
                                        <div>Wedding Records</div>

                                </a>
                     <a href="<?= Yii::$app->urlManager->createUrl(['death/index','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/death.png') ?></i>
                                        <div>Death Records</div>

                                </a>        
                      
                              
                               <a href="<?= Yii::$app->urlManager->createUrl(['baptism/index','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/visitor12.png') ?></i>
                                        <div>Baptism</div>

                                </a>
                           
                               <a href="<?= Yii::$app->urlManager->createUrl(['visitorbook/index','id'=>1])?>" class="btn btn-app" style="min-height:180px">
                                        <i><?php echo Html::img('@web/image/visitor.png') ?></i>
                                        <div>Visitors</div>

                                </a>
                             
                          </div>
                             </div>
                   
                </div>     
