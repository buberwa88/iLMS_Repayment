<?php
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */
//
////$this->title ="Student Information";
////$this->params['breadcrumbs'][] = ['label' => 'List of Students', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
  

    <div class="fixedassets-view">
        
             <div class="panel panel-info">
        <div class="panel-heading">
       Profile Details
        </div>
        <div class="panel-body">
                    <!-- /.box-header -->
                    <div class="box-body">
        <div class="col-md-7">
        <div class="fixedassets-view">
        <div class="box box-info">
                    <div class="box-header with-border">
                       <h3 class="box-title user">My Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
           <?= $this->render('viewdetails',["model"=>$model]) ?>


        </div>
        </div>
        </div>
           
        </div>
        <!-- /.col -->
        <div class="col-md-4">
            <div class="fixedassets-view">
            <div class="box box-info">
                        <div class="box-header with-border">
                           <h3 class="box-title">Photo</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
               

            </div>
            </div>
            </div>

          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
        </div>
    </div>
 