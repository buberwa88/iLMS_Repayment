<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
/* @var $this yii\web\View */
// $this->title = 'Account Home';
 $this->params['breadcrumbs'][] = $this->title;
?>
             <?=Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'nav-pills'],
                'items' => [
                    ['label' => 'Customer Profile', 'url' => ['customer/view','id'=> $clientId]],
                    ['label' => 'Motors', 'url' => ['/card/index','id'=> $clientId]],
                    ['label' => 'Non Motors', 'url' => ['/site/nhome','id'=>$clientId]],
                    ['label' => 'Invoice', 'url' => ['/invoicesummary/indexc','id'=>$clientId]],
                    ['label' => 'Cover Notes', 'url' => ['/certificate/index','id'=>$clientId]],
                     ],
                ]
             
        );
        
        ?>
                    </br>
<div class="portlet box green">
    
                <div class="portlet-title">
                        <h4><i class="ace-icon fa fa-home home-icon"></i>NON MOTOR</h4>
                </div>
    
                <div class="portlet-body ">
     
             <div class="row-fluid">
                    <div class="scoping-update">
<div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <ul class="list-group">
                <a href="<?= Yii::$app->urlManager->createUrl(['house/create','id'=>$clientId])?>"><li class="list-group-item has-button">Building & Contents</li>
                </a>
               
              <a href="<?= Yii::$app->urlManager->createUrl(['allitems/index','id'=>$clientId])?>"><li class="list-group-item has-button">All Risks</li>
                </a>
                    <a href="<?= Yii::$app->urlManager->createUrl('report/mediaanalysisreport')?>"><li class="list-group-item has-button">Workmen's Compensation</li>
                </a>
              <a href="<?= Yii::$app->urlManager->createUrl('report/mediaanalysisreport')?>"><li class="list-group-item has-button">Workmen's Compensation</li>
                </a>
                  <a href="<?= Yii::$app->urlManager->createUrl('report/mediaanalysisreport')?>"><li class="list-group-item has-button">Owners Liability</li>
                </a>
                       <a href="<?= Yii::$app->urlManager->createUrl('report/mediaanalysisreport')?>"><li class="list-group-item has-button">Occupiers and Personal Liability </li>
                </a>
                  </ul>
                </div>
</div>
</div>
                             </div>
                   
                </div>
   </div>
     

      
      
      
      


