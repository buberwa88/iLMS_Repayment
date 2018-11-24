<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Programmes List';
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
           'programme_name',
		   [
                     'attribute' => 'learning_institution_id',
                        'label'=>"Institution",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->learningInstitution->institution_name;
                        },
            ],
           'programme_code',		   
        
		],		
    ]);
    ?>
</div>
    </div>
</div>