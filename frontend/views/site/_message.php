<?php
   use yii\helpers\Html;
 ?>
<div class="alert <?=$alert;?> alert-dismissible">
                
                <h4 ><i class="icon fa fa-info"></i><?=$message?> <?= Html::a('click here to login ', ['/application/default/home-page','activeTab'=>'login_tab_id']) ?></h4>
 </h4>
          <input type="hidden" name="success"  id='successId' value=2>
              </div>