<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenaltyPayment */

$this->title = "Penalty Payment";
$this->params['breadcrumbs'][] = ['label' => 'Penalty Payment', 'url' => ['employer-penalty-payment/create']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-penalty-payment-view">
<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'control_number',
			[
                'attribute'=>'amount',
                'value'=>call_user_func(function ($data) {
                    return   $data->amount;
            }, $model),
                'format'=>['decimal',2],
            ], 
        ],
    ]) ?>

</div>
       </div>
</div>
