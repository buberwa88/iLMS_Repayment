<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

$this->title = 'Verification Framework';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <!--PLAN DETAILS-->
<p>
                <?php if (!$model->hasApplication()) { ?>
                    <?php if($model->hasVerificationItem()){ ?>
                    <?= Html::a('Confirm', ['confirm', 'id' => $model->verification_framework_id], ['class' => 'btn btn-success']) ?>
                   <?php } ?>
                    <?= Html::a('Update', ['update', 'id' => $model->verification_framework_id], ['class' => 'btn btn-primary']) ?>
                <?php } ?>

                <?php if ($model->hasApplication()) {
                      if ($model->is_active==1 && $model->verification_framework_stage==1) {
                    ?>
                    <?=
                    Html::a('Close Framework', ['close-framework', 'id' => $model->verification_framework_id], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Are you sure you want to Close & Archieve this Framework?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
                <?php }
?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?=
                    Html::a('Adjust Framework', ['verification-custom-criteria/index', 'id' => $model->verification_framework_id], [
                        'class' => 'btn btn-warning',
                        'data' => [
                            'confirm' => 'Are you sure you want to adjust this Framework?',
                            'method' => 'post',
                        ],
                    ])
                    ?>

<?php
} ?>
            </p>
            <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,        
        'attributes' => [
            'verification_framework_title',
            [
            'label'  => 'Study Level',
			'format'=>'raw',
            'value'  => call_user_func(function ($data) {
			return $data->category0->applicant_category;
            }, $model),            
        ],
            'verification_framework_desc',
            [
            'label'  => 'Confirmed',
			'format'=>'raw',
            'value'  => call_user_func(function ($data) {
			if($data->verification_framework_stage==0){
			return "<span class='label label-danger'>".No."</span>";
			}else if($data->verification_framework_stage==1){
			return "<span class='label label-success'>".Yes."</span>";
			}
            }, $model),            
        ],
            'created_at',
        [
            'label'  => 'Active',
			'format'=>'raw',
            'value'  => call_user_func(function ($data) {
			if($data->is_active==0){
			return "<span class='label label-danger'>".No."</span>";
			}else if($data->is_active==1){
			return "<span class='label label-success'>".Yes."</span>";
			}
            }, $model),            
        ],            
        ],
    ]) ?>
            <!--FRAMEWORK OTHER SECTIONS-->
            <?php
            echo TabsX::widget([
                'items' => [                    
                    [
                        'label' => 'Attachments',
                        'content' => $this->render('_verification_items', ['model' => $model, 'model_verification_items' => $model_verification_items,'searchModel'=>$searchModelVerifItems]),
                        'id' => 'atab1',
                        'active' => ($active == 'atab1') ? true : false,
                    ], 
                    [
                        'label' => 'Custom Criteria(Education)',
                        'content' => $this->render('_verification_custom_criteria_education', ['model' => $model, 'model_verification_custom_criteria_education' => $model_verification_custom_criteria_education]),
                        'id' => 'atab3',
                        'active' => ($active == 'atab3') ? true : false,
                    ],
                    [
                        'label' => 'Custom Criteria(Other) ',
                        'content' => $this->render('_verification_custom_criteria', ['model' => $model, 'model_verification_custom_criteria' => $model_verification_custom_criteria]),
                        'id' => 'atab2',
                        'active' => ($active == 'atab2') ? true : false,
                    ],                    
                    
                ],
                'position' => TabsX::POS_ABOVE,
                'bordered' => true,
                'encodeLabels' => false
            ]);
            ?>
        </div>

    </div> 
</div>