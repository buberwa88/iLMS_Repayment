<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\LoanRepaymentItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Repayment Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-item-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Loan Repayment Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'loan_repayment_item_id',
            'item_name',
            'item_code',
            [
            'attribute'=>'parent_id',    
            'header'=>'Parent',
            'format'=>'raw',    
            'value' => function($model)
            {
             if($model->parent_id !=''){
            return $model->loanRepaymentItem->item_name;
             }else{
            return "N/A"; 
             }
            },
        ],
                    [
            'attribute'=>'payable_order_list',    
            'header'=>'Order List',
            'format'=>'raw',    
            'value' => function($model)
            {
                if($model->payable_order_list !=''){
            return $model->payable_order_list;
                }else{
            return '';        
                }
            },
        ],
                    /*
        [
            'attribute'=>'payable_order_list_status',    
            'header'=>'Order Status',
            'format'=>'raw',    
            'value' => function($model)
            {
                if($model->payable_order_list_status==1){
            return "Full Paid Before Other Items";
                }else if($model->payable_order_list_status==2){
            return "Partially Depending onthe item rate";        
                }else{
                    return '';        
                }
            },
        ],
                     * 
                     */            
            //'is_active',
            [
            'attribute'=>'is_active',            
            'filter' => ['1'=>'Active', '0'=>'In Active'],
            //'format'=>'raw',    
            'value' => function($model, $key, $index)
            {   
                if($model->is_active == '1')
                {
                    return 'Active';
                }
                else
                {   
                    return 'In Active';
                }
            },
        ],
            //'created_at',
            // 'created_by',

            ['class' => 'yii\grid\ActionColumn','template'=>'{update}'],
                    
        ],
    ]); ?>
</div>
       </div>
</div>
