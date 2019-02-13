 <?php
 
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\date\DatePicker;
use kartik\detail\DetailView;
use frontend\modules\repayment\models\EmployerSearch;
/*
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
 * 
 */

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appleal-default-index">
<div class="panel panel-info">
<div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body"> 

				<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'employer_id',
            //'applicant_id',
            //'loan_summary_id',
			//'payment_date',
			[
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
            ],
			
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
            ],
			
		    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
            ],
			[
                'attribute'=>'payment_date',
				'label'=>'Pay Month',
                'format'=>'raw',
                'value'=>function($model)
            {
             return date("Y-m",strtotime($model->payment_date));                    
            },
            ],
            //'monthly_amount',
			[
            'attribute'=>'monthly_amount',
            'label'=>'Amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->monthly_amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],
            // 'payment_date',
            // 'created_at',
            // 'created_by',
            // 'bill_number',
            // 'control_number',
            // 'receipt_number',
            // 'date_bill_generated',
            // 'date_control_received',
            // 'receipt_date',
            // 'date_receipt_received',
            // 'payment_status',
            // 'cancelled_by',
            // 'cancelled_at',
            // 'cancel_reason',
            // 'gepg_cancel_request_status',
            // 'monthly_deduction_status',
            // 'date_deducted',

            //['class' => 'yii\grid\ActionColumn'],
        ],
		'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
    ]); ?>

	<br/>
</div>
       </div>
	    </div>