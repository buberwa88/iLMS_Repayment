<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Study Level';
$this->params['breadcrumbs'][] = ['label' => 'Upload Employees', 'url' => ['index-upload-employees']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-view">
    <div class="panel panel-info">
	    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           //'applicant_category',
            [
                'attribute'=>'applicant_category',
                'label'=>'Category',
                'value' => function ($model) {
                            return $model->applicant_category;
                        },
            ],
                                [
                'attribute'=>'applicant_category_code',
                'label'=>'Category Code',
                'value' => function ($model) {
                            return $model->applicant_category_code;
                        },
            ],	   
        
		],		
    ]);
    ?>
</div>
    </div>
</div>