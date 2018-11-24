<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use frontend\modules\application\models\Education;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guardian $model
 */
$this->title = 'O-level Education';
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
if(Education::find()->where("application_id = {$modelApplication->application_id} AND level = 'OLEVEL' ")->count() == 0){
 
      echo $this->render('olevel_create', [
                    'model' => $modelNew,
                ]);
}
else{
    
 echo Html::a('<i class="glyphicon glyphicon-plus"></i> Click to add  O-level Education Details if you have more than one sitting', ['olevel-create'], ['class' => '','style'=>'margin-top: -10px; margin-bottom: 15px']);   
 echo "<br/>";
 echo "<br/>";
}

 $models = Education::find()->where("application_id = {$modelApplication->application_id} AND level = 'OLEVEL' ")->all();
 $sn = 0;
    foreach ($models as $model) {
     ++$sn;   
         if($sn==1){
             $updatelink=Html::a('EDIT', ['/application/education/olevel-updates', 'id' => $model->education_id],['class' => 'btn btn-primary']); 
           }
           else{
       $updatelink=Html::a('EDIT', ['/application/education/olevel-update', 'id' => $model->education_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->education_id,'url'=>"olevel-view"], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]);      
           }
        $attributes = [
          
            [
            'group' => true,
            'label' => "OLEVEL EDUCATION  " . $sn . ': &nbsp;&nbsp; &nbsp;&nbsp; ' .$updatelink,
            'rowOptions' => ['class' => 'info'],
            'format' => 'raw',
        ],
            
            [
                'columns' => [
                  [
                        'label' => 'O-level Index#',
                        'value' => $model->registration_number,
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
                        'label' =>$model->is_necta==1?'O-LEVEL SCHOOl':"NON-NECTA INSTITUTION NAME",
                        'value' =>$model->learning_institution_id!=""?$model->learningInstitution->institution_name:"",
                        'labelColOptions'=>['style'=>'width:20%'],
                         //'valueColOptions'=>['style'=>'width:40%'],
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
  <?= Html::a('<< Go Previous Step', ['education/primary-view'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Go Next Step>>', ['education/alevel-view'], ['class' => 'pull-right']) ?>
 
            </div>
</div>
          </div>
</div>