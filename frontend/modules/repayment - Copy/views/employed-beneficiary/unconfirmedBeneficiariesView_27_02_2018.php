<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

//$this->title ="Batch Details";

$this->title = 'Unconfirmed Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-view">
    <div class="panel panel-info">
	    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
           
<?php							
							
echo TabsX::widget([
    'items' => [
        [
            'label' => 'Unconfirmed Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/unconfirmed-beneficiaries-list']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
		/*
		[
            'label' => 'Non Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/non-found-uploaded-employees']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
        [
            'label' => 'Submitted Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/beneficiaries-submitted']) . '" width="100%" height="600px" style="border: 0"></iframe>',
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