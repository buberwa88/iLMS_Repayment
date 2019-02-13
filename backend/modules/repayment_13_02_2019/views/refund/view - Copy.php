<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\Refund */

$this->title = "Refund Claims";
$this->params['breadcrumbs'][] = ['label' => 'All Refund Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
<?php							
							
echo TabsX::widget([
    'items' => [
        
		[
            'label' => "Claimant's Details",
            'content' => '<iframe src="' . yii\helpers\Url::to(['refund/view-refund', 'id' =>$model->refund_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '1',
        ],
        [
            'label' => 'Refund Claims',
            'content' => '',
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
