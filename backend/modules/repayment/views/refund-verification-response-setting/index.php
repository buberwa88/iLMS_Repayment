<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundVerificationResponseSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Refund Verification Response';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-verification-response-setting-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
						<p>
        <?= Html::a('Create Refund Verification Response', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'refund_verification_response_setting_id',
            //'verification_status',
			[
                     'attribute' => 'verification_status',
                        'label'=>"Status",
                        'value' => function ($model) {
							if($model->verification_status==1){
                           return 'Valid';
							}else if($model->verification_status==2){
							return 'InValid';	
							}else if($model->verification_status==3){
							return 'Need Further Verification';	
							}else if($model->verification_status==4){
							return 'Need Investigation';	
							}
                        },
            ],
            'response_code',
            //'access_role_master',
            //'access_role_child',
             'reason',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            // 'is_active',

            ['class' => 'yii\grid\ActionColumn',
			'template'=>'{update}{delete}'],
			
			
        ],
    ]); ?>
</div>
       </div>
</div>
