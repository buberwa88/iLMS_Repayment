<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\LoanRepaymentSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Repayment Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-setting-index">

<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Loan Repayment Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
            'attribute'=>'item_name',
            'header'=>'Item Name',
            'format'=>'raw',    
            'value' => function($model)
            {   
            return $model->loanRepaymentItem->item_name;
            },
        ],
		//'rate',
                    [
            'attribute'=>'rate',
            'header'=>'Loan Calculation Rate',
            'format'=>'raw',    
            'value' => function($model)
            {   
            return $model->rate;
            },
        ],
                    [
            'attribute'=>'rate_type',
            'header'=>'Rate Type',
            'format'=>'raw',    
            'value' => function($model)
            {   
            return $model->rate_type;
            },
        ],
                    [
            'attribute'=>'charging_interval',
            'header'=>'Charging Interval',
            'format'=>'raw',    
            'value' => function($model)
            {   
            return $model->charging_interval;
            },
        ],
        [
            'attribute'=>'item_applicable_scope',
            'header'=>'Scope Applicable',
            'format'=>'raw',    
            'value' => function($model)
            {   
            return $model->item_applicable_scope;
            },
        ],            
        //'start_date',
        [
            'attribute'=>'start_date',
            'header'=>'Start Date',
            'format'=>'raw',    
            'value' => function($model)
            {  
                if($model->start_date !=''){
            return $model->start_date;
                }else{
            return '';        
                }
            },
        ],
                    [
            'attribute'=>'end_date',
            'header'=>'End Date',
            'format'=>'raw',    
            'value' => function($model)
            {  
                if($model->end_date !=''){
            return $model->end_date;
                }else{
            return '';        
                }
            },
        ],
                    [
            'attribute'=>'item_formula',
            'header'=>'Formula',
            'format'=>'raw',    
            'value' => function($model)
            {   
            return $model->item_formula;
            },
        ],
                    [
            'attribute'=>'formula_stage',
            'header'=>'Formula Stage',
            'format'=>'raw',    
            'value' => function($model)
            {
                if($model->formula_stage==0 && $model->item_formula !=''){
            return 'General';
                }else if($model->formula_stage==1 && $model->item_formula !=''){
            return 'Before Repayment';        
                }else if($model->formula_stage==2 && $model->item_formula !=''){
            return 'On Repayment';        
                }else{
            return '';        
                }
            },
        ],
		
		[
                        'attribute' => 'calculation_mode',
                        //'vAlign' => 'middle',
                        'label'=>"Calculation Mode",
                        'value' => function ($model) {
                            return $model->calculation_mode==1?"Once at first":"Continous";
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [1=>'Once at first',2=>'Continous'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ],
			[
            'attribute'=>'formula_stage_level',
            'header'=>'Stage Level',
            'format'=>'raw',    
            'value' => function($model)
            {
                if($model->formula_stage_level==1 && $model->formula_stage==1){
            return 'From Disbursement date';
                }else if($model->formula_stage_level==2 && $model->formula_stage==1){
            return 'Due Loan';        
                }else if(($model->formula_stage_level !=3 && $model->formula_stage_level !=2 && $model->formula_stage_level !=1) && $model->formula_stage==2){
            return 'On Repayment';        
                }else{
            return 'N/A';        
                }
            },
        ],
                                [
            'attribute'=>'payment_deadline_day_per_month',
            'header'=>'Deadline Day/Month',
            'format'=>'raw',    
            'value' => function($model)
            {  
                            if($model->payment_deadline_day_per_month !=''){
            return $model->payment_deadline_day_per_month;
                            }else{
            return 'N/A';                    
                            }
            },
        ],
                    [
            'attribute'=>'loan_repayment_rate',
            'header'=>'Loan Repayment Rate',
            'format'=>'raw',    
            'value' => function($model)
            {
                if($model->loan_repayment_rate !=''){
            return $model->loan_repayment_rate."%";
                }else{
            return '';        
                }
            },
        ],
            
			[
                        'attribute' => 'is_active',
                        //'vAlign' => 'middle',
                        'label'=>'Applicable?',
                        'value' => function ($model) {
                            return $model->is_active==0?"No":"Yes";
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [1=>'Yes',0=>'No'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ],                   
            // 'created_at',
            // 'created_by',

            //['class' => 'yii\grid\ActionColumn','template'=>'{update}{delete}'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return \backend\modules\repayment\models\LoanRepaymentSetting::checkItemUsed()==0 ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'update'),
                        ]):'';
                    },
                    'delete' => function ($url, $model) {
                        return \backend\modules\repayment\models\LoanRepaymentSetting::checkItemUsed()==0? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            //'class' => 'btn btn-info',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                //'method' => 'get',
                                //'title' => Yii::t('app', 'lead-update'),
                            ],
                        ]):'';
                    }

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'update') {
                        $url ='index.php?r=repayment/loan-repayment-setting/update&id='.$model->loan_repayment_setting_id;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url ='index.php?r=repayment/loan-repayment-setting/delete-itemsetting&id='.$model->loan_repayment_setting_id;
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
</div>
       </div>
</div>
