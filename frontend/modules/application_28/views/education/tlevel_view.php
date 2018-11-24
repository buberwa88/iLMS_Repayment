<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use frontend\modules\application\models\Education;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guardian $model
 */
    $this->title = 'Tertiary-level Education';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
 

<div class="guardian-view">
          <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
<?php

//$r = Education::getOlevelDetails("S0131/0127/2001");
//var_dump($r);
//die;
if(Education::find()->where("application_id = {$modelApplication->application_id} AND  level IN('BACHELOR','MASTERS')")->count() == 0){
 
      echo $this->render('tlevel_create', [
                    'model' => $modelNew,
                ]);
}
else{
    
 echo Html::a('<i class="glyphicon glyphicon-plus"></i> Click to add  Tertiary-level Education Details if you have more than one ', ['olevel-create'], ['class' => '','style'=>'margin-top: -10px; margin-bottom: 15px']);   
 echo "<br/>";
 echo "<br/>";
}

 $models = Education::find()->where("application_id = {$modelApplication->application_id} AND level IN('BACHELOR','MASTERS')")->all();
 $sn = 0;
    foreach ($models as $model) {
     ++$sn;   
        
       $updatelink=Html::a('EDIT', ['/application/education/tlevel-update', 'id' => $model->education_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->education_id,'url'=>"tlevel-view"], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]);      
     
        $attributes = [
          
            [
            'group' => true,
            'label' => "T-LEVEL EDUCATION  " . $sn . ': &nbsp;&nbsp; &nbsp;&nbsp; ' .$updatelink,
            'rowOptions' => ['class' => 'info'],
            'format' => 'raw',
        ],
            [
                'columns' => [
                  [
                        'label' => 'Level of Study',
                        'value' => $model->level,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                     [
                        'label' => 'Institution Name',
                        'value' => $model->learning_institution_id!=""?$model->learningInstitution->institution_name:"",
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                ],
               ],
                [
                'columns' => [
                  [
                        'label' => 'Programme Name',
                        'value' => $model->programme_name,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                     [
                        'label' => 'Registration #',
                        'value' => $model->avn_number,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                ],
               ],
              [
                'columns' => [
                  [
                        'label' => 'Entry Year',
                        'value' => $model->entry_year,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                     [
                        'label' => 'Completion Year',
                        'value' => $model->completion_year,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                ],
               ],
            [
                'columns' => [
                  [
                        'label' => 'Country',
                        'value' => $model->country_id,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                     [
                        'label' => 'Region Name',
                        'value' => $model->region_id,
                        'labelColOptions'=>['style'=>'width:20%'],
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
      // echo $model->sponsor_proof_document;
       echo $this->render('_sponsored_view_details', [
                    'model' => $model,
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
                                <td colspan='2'><b>Employer Letter</b> </td>
                              
                              </tr>";
                           echo '<tr><td colspan="2">
           <iframe src="'.$model->employer_letter.'" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>';
                         }
               
                      ?>
                    </tbody>
                    
                  </table> 
        </div>
   <div class="col-lg-12">
  <?= Html::a('<< Go Previous Step', ['education/primary-view'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Go Next Step>>', ['education/alevel-view'], ['class' => 'pull-right']) ?>
 
            </div>
</div>
          </div>
</div>