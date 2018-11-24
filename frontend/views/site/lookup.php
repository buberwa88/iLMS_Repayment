 
<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */

$this->title = 'Look Up Area';
 
$this->params['breadcrumbs'][] = $this->title;
?>
  <div class="box box-info">
            <div class="box-header with-border">
               <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
             

              <h3 class="box-title">General Look</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                 <ol>
                <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupzone/index','id'=>1])?>">                          
                                       Zone

                                </a></li>
               <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupdeacon/index','id'=>1])?>">                          
                                       Deacon

                                </a></li>
                                
                <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupeducation/index','id'=>1])?>">                          
                                Education

                                </a></li>
                   <li> <a href="<?= Yii::$app->urlManager->createUrl(['organization/view','id'=>1])?>">                          
                                Church Information

                                </a></li>
                     <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupofferingtype/index','id'=>1])?>">                          
                              Offering Type

                                </a></li>
                              <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupposition/index','id'=>1])?>">                          
                                  Position

                                </a></li>
              </ol>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- ./col -->
        <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
            

              <h3 class="box-title">Children Lookup</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ol>
                <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupchildgroup/index','id'=>1])?>">                          
                                      Group

                                </a></li>
                 <li> <a href="<?= Yii::$app->urlManager->createUrl(['childgevent/index','id'=>1])?>">                          
                                     Events

                                </a></li>
               <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupschool/index','id'=>1])?>">                          
                                    School

                                </a></li>
                
              </ol>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- ./col -->
        <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
            

              <h3 class="box-title">Members Lookup </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <ol>
                <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupssch/index','id'=>1])?>">                          
                                 SSCH

                                </a></li>
               <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupservice/index','id'=>1])?>">                          
                                   Service 

                                </a></li>
            
                
              </ol>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
           

              <h3 class="box-title">Assets Lookup </h3>
            </div>
            <!-- /.box-header   -->
            <div class="box-body">
            <ol>
                  
              <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupassetcategory/index','id'=>1])?>">                          
                                   Assets Class

                                </a></li>
                    <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupassetsubcategory/index','id'=>1])?>">                          
                                   Assets  Category

                                </a></li>
                <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookuphydropowername/index','id'=>1])?>">                          
                                   Assets Sub Category

                                </a></li>
                <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookuphydropowerstation/index','id'=>1])?>">                          
                                       Station

                                </a></li>
               <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookuphydropowerlocation/index','id'=>1])?>">                          
                                       Power Location

                                </a></li>
                                
                <li> <a href="<?= Yii::$app->urlManager->createUrl(['lookupsubstation/index','id'=>1])?>">                          
                                      Sub-Location

                                </a></li>
              </ol>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
                    
        <!-- ./frame end -->              
    </div>
                    </div>
 </div>
</div>
