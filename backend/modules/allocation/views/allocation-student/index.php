<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Loanee';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
       
     <?php  echo $this->render('_searchmaster', ['model' => $searchModel]); ?>
        
            <div  id="formId">
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
               
            //'application_id',
           // 'applicant_id',
                        
            [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'vAlign' => 'middle',
                       // 'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
                    ],
                    [
                     'attribute' => 'surname',
                          'label'=>"Last Name",
                        'vAlign' => 'middle',
                         
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
                    ],
                    [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        'vAlign' => 'middle',
                       // 'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
                    ],
            ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
    ]); ?>
</div>
 </div>
</div>
</div>