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
$applicant_category=$modelApplication->applicant_category_id>0?$modelApplication->applicantCategory->applicant_category:"";

?>
 

<div class="guardian-view">
          <div class="panel panel-info">
        <div class="panel-heading">
        
         Step 7 : <?= Html::encode($this->title) ?><label class="pull-right" style="font-size:16px"><?=$modelApplication->loanee_category." ".$applicant_category;?></label>
       
        </div>
        <div class="panel-body">
<?php

 
if(Education::find()->where("application_id = {$modelApplication->application_id} AND  level IN('BACHELOR','MASTERS')")->count() == 0){
 
      echo $this->render('tlevel_create', [
                    'model' => $modelNew,
                    'modelApplication'=>$modelApplication
                ]);
}
else{
    
 echo Html::a('<i class="glyphicon glyphicon-plus"></i> Click to add  Tertiary-level Education Details if you have more than one ', ['tlevel-create'], ['class' => '','style'=>'margin-top: -10px; margin-bottom: 15px']);   
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
            'label' => "T-LEVEL EDUCATION  " . $sn . ': <div class="pull-right">&nbsp;&nbsp; &nbsp;&nbsp; ' .$updatelink."</div>",
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
                        'value' => $model->country_id>0?$model->country->country_name:"",
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                     [
                        'label' => 'Region Name',
                        'value' => $model->region_id>0?$model->region->region_name:"",
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
    
     if($modelApplication->applicant_category_id==2||$modelApplication->applicant_category_id==5){
         $link_foward='applicant-associate/guarantor-view';   
        }
        else{
       $link_foward='applicant-associate/parent-view';        
        }
    ?>

   <div class="col-lg-12">
  <?= Html::a('<< Previous Step', ['education/alevel-view'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Next Step>>', [$link_foward], ['class' => 'pull-right']) ?>
 
            </div>
</div>
          </div>
</div>