<?php

use yii\helpers\Html;
use yii\grid\GridView;

$session = Yii::$app->session;
$refund_claim_id = $session->get('refund_claimant_id');
$this->title = Yii::t('app', 'Loan Refund Applications');
$refund_application_id = $session->get('refund_application_id');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-setting-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
            <a href="<?= Yii::$app->urlManager->createUrl(['site/logout-refund', 'id' => $refund_claim_id]) ?>" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa  fa-power-off"></i> Logout</a>
        </div>
        <div class="panel-body">

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $model,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['label' => 'created at',
                        'attribute' => 'created_at',
                        'value' => function ($model) {
                            return date('d-M-Y', strtotime($model->created_at));
                        }
                    ],
                    'application_number',
                    'refund_claimant_amount',
//                    'academic_year_id',
                    //['label' => 'Trustee Name',
                    ['label' => 'Name',
                        'value' => function ($model) {
                            return $model->trustee_firstname . ' ' . $model->trustee_midlename . ' ' . $model->trustee_surname;
                        }
                    ],
//                    'trustee_firstname:ntext',
//                    'trustee_midlename:ntext',
//                    'trustee_surname:ntext',
//                    'trustee_phone_number:ntext',
                    ['label' => 'Mobile No',
                        'attribute' => 'trustee_phone_number',
                        'value' => function ($model) {
                            return $model->trustee_phone_number;
                        }
                    ],
                    'trustee_email:ntext',
                    ['label' => 'Status',
                        'value' => function($model) {
                            return strtoupper($model->getCurrentStutusName());
                        }
                    ],
                    [
                        'label' => '',
                        'value' => function($model) {
                            //return Html::a("Application Details", ['/repayment/refund-application-operation/view-refund','id'=>$model->refund_application_id,'action' => 'view'], ['class'=>'label label-success']);
                            return yii\helpers\Html::a("VIEW", ['site/refund-applicationview', 'refundApplicationID' => $model->refund_application_id]);
                        },
                                'format' => 'raw',
                            ],
                        /*
                          ['class' => 'yii\grid\ActionColumn',
                          'template' => '{view}',
                          'buttons' => [

                          'view' => function ($url, $model) {
                          $url = yii\helpers\Url::to(['site/refund-applicationview', 'refundApplicationID' => $model->refund_application_id]);
                          return Html::a('<span class="glyphicon glyphicon-search"></span>', $url, [
                          'title' => 'View Details',
                          'data-method' => 'get',
                          ]);
                          }
                          ]
                          ],
                        
                        /*
                          [
                          'label'=>'',
                          'value'=>function($model) use($refund_application_id){
                          return yii\helpers\Html::a("VIEW", ['site/refund-applicationview', 'refundApplicationID' => $refund_application_id]);
                          },
                          'format'=>'raw',
                          ],
                         */
                        ],
                    ]);
                    ?>
        </div>
    </div>
</div>

