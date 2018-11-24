<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployerPenaltySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monthly Penalty';
$this->params['breadcrumbs'][] = $this->title;
?>
	<div class="employer-penalty-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
						
						<?= $this->render('_form', [
                                'model' => $model,
                                ]) ?>

            <?php
            echo TabsX::widget([
                'items' => [

                    [
                        'label' => 'Penalties',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['employer-penalty/penality-view']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '2',
                    ],
					[
                        'label' => 'Penalties Payments',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['employer-penalty-payment/index']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '2',
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
