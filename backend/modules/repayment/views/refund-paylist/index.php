<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundPaylistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Refund Pay Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-paylist-index">

    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php
            echo kartik\tabs\TabsX::widget([
                'items' => [
                    [
                        'label' => 'Pending Refund (For Pay List)',
                        'content' => $this->render('_refund_pending_paylist', ['model' => $model, 'dataProvider' => $pending_refunds, 'pendingModel' => $pendingModel]),
                        'id' => 'atab1',
                        'active' => ($active == 'atab1') ? true : false,
                    ],
                    [
                        'label' => 'Refunds Pay Lists',
                        'content' => $this->render('_refund_paylists', ['model' => $model, 'dataProvider' => $paylists, 'paylistModel' => $paylistModel]),
                        'id' => 'atab1',
                        'active' => ($active == 'atab1') ? true : false,
                    ],
                    [
                        'label' => 'Paid Refunds',
                        'content' => $this->render('_refund_paid', ['model' => $model, 'dataProvider' => $paid_refunds, 'paidModel' => $paylistModel]),
                        'id' => 'atab1',
                        'active' => ($active == 'atab1') ? true : false,
                    ],
                ],
                'position' => kartik\tabs\TabsX::POS_ABOVE,
                'bordered' => true,
                'encodeLabels' => false
            ]);
            ?>
        </div>
    </div>
</div>