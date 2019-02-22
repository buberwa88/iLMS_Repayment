<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request GSPP Monthly Deductions';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
    function check_status2() {
        //form-group field-user-verifycode
        document.getElementById("hidden").style.display = "none";
        document.getElementById("loader").style.display = "block";
    }
</script>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
<div class="panel-heading">
					  <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body"> 
						<div class="block" id="hidden">

<?= Html::a('Reguset GSPP Monthly Deductions', ['requestgspp-monthdeductionform'], ['class' => 'btn btn-success','onclick'=>'return  check_status()']) ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?= Html::a('Send Control #', ['sendcontrolngspp'], ['class' => 'btn btn-warning','onclick'=>'return  check_status2()']) ?>
<br/><br/>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'bill_number',
            //'amount',
			[
            'attribute'=>'amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],
            'control_number',
			[
            'attribute'=>'control_number_date',
			'label'=>'Bill Date',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return date("Y-m-d",strtotime($model->control_number_date));
            }, 
            ],
            'deduction_month',
			/*
			[
            'attribute'=>'status',
			'label'=>'GePG Status',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->status;
            }, 
            ],
			*/
			[
                        'attribute' => 'status',
						'label'=>'GePG Status',
                        'value' => function ($model) {
                           if($model->status==0){
							 $status='<p class="btn green"; style="color:red;">Pending</p>';   
							}else if($model->status==1){
							 $status='<p class="btn green"; style="color:green;">Sent to GePG</p>'; 
							}else if($model->status==2){
							$status='<p class="btn green"; style="color:green;">Sent to GSPP</p>';	
							}
							return $status;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [0=>'Pending',1=>'Sent to GePG',2=>'Sent to GSPP'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ],
			
            'gepg_date',
						
			[
                        'attribute' => 'amount_status',
						'label'=>'Amount Status',
                        'value' => function ($model) {
                           if($model->amount_status==0){
							 $status='<p class="btn green"; style="color:red;">Pending</p>';   
							}else if($model->amount_status==1){
							 $status='<p class="btn green"; style="color:green;">GSPP amount OK</p>'; 
							}else if($model->amount_status==2){
							$status='<p class="btn green"; style="color:green;">GSPP amount differ</p>';	
							}else if($model->amount_status==3){
							$status='<p class="btn green"; style="color:green;">Overall amount OK</p>';	
							}else if($model->amount_status==4){
							$status='<p class="btn green"; style="color:green;">Overall amount differ</p>';	
							}
							return $status;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [0=>'Pending',1=>'GSPP amount OK',2=>'GSPP amount differ',3=>'Overall amount OK',4=>'Overall amount differ'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	</div>
	<p>
     <center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>
    </p>
</div>
       </div>
</div>
