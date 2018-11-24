<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

//$this->title ="Batch Details";

$this->title = 'Unconfirmed Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixedassets-view">
<div class="box box-info">
            <div class="box-header with-border">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
           
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