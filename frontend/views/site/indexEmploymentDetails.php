<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\tabs\TabsX;
use kartik\detail\DetailView;
use frontend\modules\repayment\models\RefundClaimantEmployment;
//set session
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
//end set session

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantEducationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Step 3: Employment Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-education-history-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Add New Employment Details ', ['create-employment-details'], ['class' => 'btn btn-success']) ?>
            </p><br/><br/>
            <?php  $modelRefundClaimantEducationHistory = RefundClaimantEmployment::find()->where("refund_application_id={$refund_application_id}")->all();


            $sn = 0;
            foreach ($modelRefundClaimantEducationHistory as $model) {
                ++$sn;
                $attributes = [

                    [
                        'columns' => [

                            [
                                'label' => 'Employer Name',
                                'value'=>$model->employer_name,
                                //'labelColOptions'=>['style'=>'width:20%'],
                                //'valueColOptions'=>['style'=>'width:30%'],
                            ],

                        ],
                    ],

                    [
                        'columns' => [

                            [
                                'label'=>'Employee ID/Check #',
                                'value'=>$model->employee_id,
                                //'labelColOptions'=>['style'=>'width:20%'],
                                //'valueColOptions'=>['style'=>'width:30%'],
                            ]
                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label'=>'Start Date',
                                'value'=>$model->start_date,
                                //'labelColOptions'=>['style'=>'width:20%'],
                                //'valueColOptions'=>['style'=>'width:30%'],
                            ]
                        ],
                    ],

                    [
                        'columns' => [

                            [
                                'label'=>'End Date',
                                'value'=>$model->end_date,
                                //'labelColOptions'=>['style'=>'width:20%'],
                                //'valueColOptions'=>['style'=>'width:30%'],
                            ],
                        ],
                    ],

                ];


                echo DetailView::widget([
                    'model' => $model,
                    'condensed' => true,
                    'hover' => true,
                    'mode' => DetailView::MODE_VIEW,
                    'attributes' => $attributes,
                ]);
                echo '<div class="text-right">
	<p>';
                ?>
                <?= Html::a('Update/Edit', ['update-contactperson', 'id' => $model->refund_claimant_employment_id,'emploID'=>$model->refund_claimant_employment_id], ['class' => 'btn btn-primary']) ?>
                <?php
                echo "</p></div>";
            }?>
            <br/></br/>
            <div class="rowQA">
                <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK",['site/list-steps-nonbeneficiary','id'=>$refundClaimantid]);?></div>
                <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/list-steps-nonbeneficiary','id'=>$refundClaimantid]);?></div>
            </div>
        </div>
    </div>
