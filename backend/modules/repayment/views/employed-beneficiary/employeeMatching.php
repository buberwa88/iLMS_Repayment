<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees with failed matching';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'attribute'=>'employer_id',
            'header'=>'Employer',
            'format'=>'raw',    
            'value' => function($model)
            {   
                    return $model->employer->employer_name;
            },
        ],
                    [
            'attribute'=>'f4indexno',
            'header'=>'Index Number',
            'format'=>'raw',    
            'value' => function($model)
            {   
                    return $model->f4indexno;                
            },
        ],
		[
            'attribute'=>'firstname',
            'header'=>'First Name',
            'format'=>'raw',    
            'value' => function($model)
            {   
                    return $model->firstname;                
            },
        ],
		[
            'attribute'=>'middlename',
            'header'=>'Middle Name',
            'format'=>'raw',    
            'value' => function($model)
            {   
                    return $model->middlename;                
            },
        ],
		[
            'attribute'=>'surname',
            'header'=>'Last Name',
            'format'=>'raw',    
            'value' => function($model)
            {   
                    return $model->surname;                
            },
        ],
            [
			 'attribute'=>'employee_id',
            'header'=>'Employee ID',
            'format'=>'raw',    
            'value' => function($model)
            {   
                    return $model->employee_id;                
            },
        ],
		[
		    'attribute'=>'vote_number',
            'header'=>'% of Match',
            'format'=>'raw',    
            'value' => function($model)
            {   
                    return '';                
            },
        ],
		/*
        [
            'header'=>'Match Description',
            'format'=>'raw',    
            'value' => function($model)
            {   
                    return '';                
            },
        ],
         */		
            ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>