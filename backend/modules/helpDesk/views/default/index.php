 <?php
 
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Help Desk';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appleal-default-index">
    <div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
    </div>
        <div class="panel-body">
   <?php     
   echo $this->render('_search', ['model' => $searchModel,'action'=>'index']); 
   //echo"<pre/>";var_dump($application_id);
   ?>
   
        <div class="panel-body">
		
		<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'application_id',
           // 'applicant_id',
              [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        //'width' => '200px',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->applicant->f4indexno, ['/helpDesk/default/view','id'=>$model->application_id]);
                        },
                    ],
              [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->applicant->user->firstname, ['/helpDesk/default/view','id'=>$model->application_id]);
                        },
                    ],
                    [
                     'attribute' => 'middleName',
                        'label'=>"Middle Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->applicant->user->middlename, ['/helpDesk/default/view','id'=>$model->application_id]);
                        },
                    ],
                    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->applicant->user->surname, ['/helpDesk/default/view','id'=>$model->application_id]);
                        },
                    ], 
                    [
                     'attribute' => 'sex',
                        'label'=>"Sex",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->applicant->sex, ['/helpDesk/default/view','id'=>$model->application_id]);
                        },
                    ],
                                [
                        'label'=>"Form #",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->application_form_number, ['/helpDesk/default/view','id'=>$model->application_id]);
                        },
                    ],
                                [
                        'label'=>"Year",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->academicYear->academic_year, ['/helpDesk/default/view','id'=>$model->application_id]);
                        },
                    ],
            
             [
               'label'=>'',
               'value'=>function($model){
                  return Html::a("VIEW", ['/helpDesk/default/view','id'=>$model->application_id], ['class'=>'label label-success']);
               },
               'format'=>'raw',
             ],
        ],
    ]); ?>
    
</div>
  </div>
</div>
    </div>
