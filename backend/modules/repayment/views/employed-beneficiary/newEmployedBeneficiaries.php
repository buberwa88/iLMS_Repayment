<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

//$this->title ="Batch Details";

$this->title = 'New Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
           
<?php							
							
echo TabsX::widget([
    'items' => [
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/new-employed-beneficiaries-found']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
		[
            'label' => 'Non Beneficiaries(Employees with no loan)',
            'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/new-employeenoloan']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
		[
            'label' => 'Non Applicants',
            'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/non-found-uploaded-employees']) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
        [
            'label' => 'Submitted Beneficiaries(Waiting employers confirmation)',
            'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/beneficiaries-submitted']) . '" width="100%" height="600px" style="border: 0"></iframe>',
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