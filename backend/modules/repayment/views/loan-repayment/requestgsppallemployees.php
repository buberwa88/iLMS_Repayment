<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request GSPP All Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
    function check_status() {
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
<?= Html::a('Request GSPP All Employees', ['requestgspp-allemploydeductform'], ['class' => 'btn btn-success']) ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?= Html::a('Check Beneficiary', ['checkgspp-beneficiary'], ['class' => 'btn btn-warning','onclick'=>'return  check_status()']) ?>
<br/><br/>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
            'attribute'=>'first_name',
			'label'=>'First Name',
            'format'=>'raw',
            'value' =>function($model)
            {
                 return $model->first_name;
            },
            ],
            [
                'attribute'=>'middle_name',
                'label'=>'Middle Name',
                'format'=>'raw',
                'value' =>function($model)
                {
                    return $model->middle_name;
                },
            ],
            [
                'attribute'=>'surname',
                'label'=>'Last Name',
                'format'=>'raw',
                'value' =>function($model)
                {
                    return $model->surname;
                },
            ],
            [
                'attribute'=>'check_number',
                'label'=>'Check #',
                'format'=>'raw',
                'value' =>function($model)
                {
                    return $model->check_number;
                },
            ],
            [
                'attribute'=>'employment_date',
                'label'=>'Employment Date',
                'format'=>'raw',
                'value' =>function($model)
                {
                    if($model->employment_date !='0000-00-00' && $model->employment_date !=''){
                        return $model->employment_date;
                    }else{
                        return '';
                    }

                },
            ],
            [
                'attribute'=>'vote_name',
                'label'=>'Employer',
                'format'=>'raw',
                'value' =>function($model)
                {
                    return $model->vote_name;
                },
            ],
            [
                'attribute'=>'sub_vote_name',
                'label'=>'Department',
                'format'=>'raw',
                'value' =>function($model)
                {
                    return $model->sub_vote_name;
                },
            ],
			[
                        'attribute' => 'checked_status',
						'label'=>'Status',
                        'value' => function ($model) {
                           if($model->checked_status==0){
							 $status='<p class="btn green"; style="color:red;">Pending</p>';   
							}else if($model->checked_status==1){
							 $status='<p class="btn green"; style="color:green;">Beneficiary not onrepayment</p>';
							}else if($model->checked_status==2){
							$status='<p class="btn green"; style="color:green;">Beneficiary onrepayment</p>';
							}else if($model->checked_status==3){
                               $status='<p class="btn green"; style="color:green;">Nonbeneficiary</p>';
                           }else if($model->checked_status==4){
                               $status='<p class="btn green"; style="color:green;">Checked employee onrepayment</p>';
                           }
							return $status;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [0=>'Pending',1=>'Beneficiary not onrepayment',2=>'Beneficiary onrepayment',3=>'Nonbeneficiary',4=>'Checked employee onrepayment'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ],
            //['class' => 'yii\grid\ActionColumn'],
        ],
    'hover' => true,
    'condensed' => true,
    'floatHeader' => true,
    ]); ?>
                            </div>
    <p>
     <center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>
    </p>
</div>
       </div>
</div>
