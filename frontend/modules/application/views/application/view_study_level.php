<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guardian $model
 */
$this->title = 'Specify  Applicant Category';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;
$applicant_category=$model->applicant_category_id>0?$model->applicantCategory->applicant_category:"";

?>
<div class="guardian-view">
          <div class="panel panel-info">
        <div class="panel-heading">
     Step 2 : <?= Html::encode($this->title) ?><label class="pull-right" style="font-size:16px"><?=$model->loanee_category." ".$applicant_category;?></label>
        </div>
        <div class="panel-body">
<?php
            if ($model->loanee_category==""||$model->applicant_category_id==""){
  echo $this->render('_study_level', [
        'model' => $model,
       
    ]);
            }
            else{
 $sn = 0;
   
     ++$sn;   
 
        $attributes = [
           
            [
            'group' => true,
            'label' => ' <div class="pull-right">&nbsp;&nbsp; &nbsp;&nbsp; '.Html::a('EDIT', ['/application/application/study-update', 'id' =>$model->application_id],['class' => 'btn btn-primary'])."</div>",
            'rowOptions' => ['class' => 'info'],
            'format' => 'raw',
         ],
            
            [
                'columns' => [
                  [
                        'label' => 'Applicant Category',
                        'value' => $model->loanee_category,
                        'labelColOptions'=>['style'=>'width:10%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                 
                ],
               ],
            
            
                           [
                'columns' => [
                    [
                        'label' => 'Study Level',
                        'value' => $model->applicant_category_id!=""?$model->applicantCategory->applicant_category:"",
                        'labelColOptions'=>['style'=>'width:10%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                 
                ],
               ],
                
            
           
            
        ];
    

    echo DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,
    ]);
            }
    ?>
                <div class="col-lg-12">
             <table id="example2" class="table table-bordered table-hover">
            
                    <tbody>
                   <?php  
                 
                       if($model->admission_letter!=""){
                      echo "<tr>
                                <td colspan='2'><b>Admission Letter </b> </td>
                                
                              </tr>";
                                 echo '<tr><td colspan="2">
           <iframe src="'.$model->admission_letter.'" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>';
                       }
                   if($model->employer_letter!=""){ 
                       echo "<tr>
                                <td colspan='2'><b>Employer Introducation  Letter</b> </td>
                              
                              </tr>";
                           echo '<tr><td colspan="2">
           <iframe src="'.$model->employer_letter.'" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>';
                         }
               
                      ?>
                    </tbody>
                    
                  </table> 
        </div>
   <div class="text-right1">
  <?= Html::a('<< Previous Step', ['applicant/pay-application-fee'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Next Step>>', ['default/my-profile'], ['class' => 'pull-right']) ?>
 
            </div>
</div>
          </div>
</div>