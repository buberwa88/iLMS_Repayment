<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

//$this->title ="Batch Details";

$this->title = 'Loan Beneficiaries';
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
            'label' => 'Loan Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/active-employed-beneficiaries']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
		/*
        [
            'label' => 'Employed Non-Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/beneficiaries-submitted']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
        [
            'label' => 'Pending Registered Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-beneficiary/index']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
*/		
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
?>
</div>
    </div>
</div>   