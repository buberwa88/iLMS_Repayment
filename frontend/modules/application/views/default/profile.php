<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */
//
////$this->title ="Student Information";
 $applicant_category=$modelApplication->applicant_category_id>0?$modelApplication->applicantCategory->applicant_category:"";
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
//$this->params['breadcrumbs'][] = $this->title;

?>
  

    <div class="fixedassets-view">
        
             <div class="panel panel-info">
        <div class="panel-heading">
      Step 3 : Applicant's Basic Information <label class="pull-right" style="font-size:16px"><?=$modelApplication->loanee_category." ".$applicant_category;?></label>
        </div>
        <div class="panel-body">
           
  
                    <!-- /.box-header -->
                    <div class="box-body">
      
        <div class="col-md-8">
        <div class="fixedassets-view">
        <div class="box box-info">
                    <div class="box-header with-border">
                       <h3 class="box-title user">My Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
    
           <?= $this->render('_viewprofile',["model"=>$model, 'modelall' => $modelall,"modelApplication"=>  $modelApplication,]) ?>
     
        </div>
        </div>
        </div>
           
        </div>
        <!-- /.col -->
        <div class="col-md-3">
            <div class="fixedassets-view">
            <div class="box box-info">
                        <div class="box-header with-border">
                            <center><h3 class="box-title">PASSPORT PHOTO</h3></center>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                                 <?php
//                             $form = ActiveForm::begin([
//                                    'type' => ActiveForm::TYPE_VERTICAL,
//
//                                     'options' => ['enctype' => 'multipart/form-data'],
//                                    'enableClientValidation' => TRUE,
//                        ]);
//                     
	             echo "<table border='0'  style='float:right;width:100%' class='table table-striped table-bordered table-hover'>"
			."<tr height = '150px'><td width = 120px;><center><input type='image' src='{$modelApplication->passport_photo}' style='width:150px;height:160px' value=''</center></td></tr>"
			 ."<tr><td style='text-align:center'></td></tr>"
			."</table> ";
//                         echo $form->field($modelApplication, 'passport_photo')->widget(FileInput::classname(), [
//                                'options' => ['accept' => 'image/*'],
//                                    'pluginOptions' => [
//                                    'showCaption' => false,
//                                    'showRemove' => false,
//                                    'showUpload' => TRUE,
//                                   // 'maxFileSize'=>2800,
//                                    'browseClass' => 'btn btn-primary btn-block',
//                                    'browseIcon' => '<i class="fa fa fa-camera"></i> ',
//                                    'browseLabel' =>  'Attach Passport Photo'
//                                ]
//                            ]);
////        
//                    ActiveForm::end();
                    ?>
      
                  </div>
            </div>
            </div>
      
          <!-- /.nav-tabs-custom -->
        </div>
        <div class="col-lg-12">
             <table id="example2" class="table table-bordered table-hover">
            
                    <tbody>
                   <?php  
                     if($modelall->disability_status!=""){
                 echo "<tr>
                        <td width='300px'><b>Are you disabled ?</b></td>
                        <td>".$modelall->disability_status."</td>
                      </tr>";
                     }
                       if($modelall->disability_status=="YES"){
                      echo "<tr>
                                <td colspan='2'><b>Disability Document </b> </td>
                                
                              </tr>";
                                 echo '<tr><td colspan="2">
           <iframe src="'.$modelall->disability_document.'" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>';
                       }
                   if($modelall->identification_document!=""){ 
                       echo "<tr>
                                <td colspan='2'><b>Identification Document</b> </td>
                              
                              </tr>";
                           echo '<tr><td colspan="2">
           <iframe src="'.$modelall->identification_document.'" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>';
                         }
               if($modelall->birth_certificate_document!=""){
                     echo "<tr>
                                <td colspan='2'><b>Birth Certificate Document</b></td>
                         
                              </tr>";
                     
                        
                       echo '<tr><td colspan="2">
           <iframe src="'.$modelall->birth_certificate_document.'" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>';
                        }
                  if($modelall->tasaf_support=="YES"&&$modelall->tasaf_support_document!=""){
                     echo "<tr>
                                <td colspan='2'><b>TASAF Proof Document</b></td>
                         
                              </tr>";
                     
                        
                       echo '<tr><td colspan="2">
           <iframe src="'.$modelall->tasaf_support_document.'" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>';
                        }
                      ?>
                    </tbody>
                    
                  </table> 
              <p>
        <?php
         if($modelall->place_of_birth>0||$modelall->date_of_birth!=""){
                        $label="  edit information";    
                     }
                     else{
                         $label="  add more information";
                     }
        
         ?>
        
       <div class="col-lg-12">
     <?= Html::a("Click to $label ", ['updateprofile', 'id' => $model->user_id],['class' => 'btn btn-primary pull-left']); ?>
           <br>
           <br>
           <br>
       </div>
        </div>
        
            <div class="col-lg-12">
  <?= Html::a('<< Previous Step', ['application/study-view'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Next Step>>', ['education/primary-view'], ['class' => 'pull-right']) ?>
 
            </div>
        <!-- /.col -->
      </div>
        </div>
    </div>
    </div>