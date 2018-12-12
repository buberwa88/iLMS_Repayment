<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;
use backend\modules\application\models\VerificationFramework;
use backend\modules\application\models\VerificationFrameworkItem;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use kartik\widgets\Select2;
 


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">         
            <?php //echo Html::encode($this->title) ?>
            Loan Item
        </div>
        <div class="panel-body">

     <?php
	//$results=\backend\modules\allocation\models\Allocation::find()->where("application_id = {$model->application_id} AND academic_year_id={$model->academic_year_id} AND is_canceled='0'")->all();
     //echo $applicant_id;
     $dataProvider=\frontend\modules\application\models\Application::getLoanItemsDisbursedheslb($application_id,$academic_year_id,$applicant_id);
        ?>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'hover' => true,    
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],  
            
              [
                     'attribute' => 'loan_item_id',
                        'label'=>"Item",
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->loanItem->item_name;
                        },
                    ],
					
            [
                     //'attribute' => 'allocatedate',
                        'label'=>"Date",
                        //'width' => '200px',
                        'value' => function ($model) {
                            return date("d-m-Y",strtotime($model->status_date));
                        },
                    ],
             
             
                    [
                     'attribute' => 'disbursed_amount',
                         'label'=>"Amount",
                        'hAlign' => 'right',
                        'format' => ['decimal', 2],
                         
                       // 'width' => '200px',
                        'value' => function ($model) {
                            return $model->disbursed_amount;
                        },
                    ],                   
        ],
    ]); ?>
</div>
</div>
    </div>
