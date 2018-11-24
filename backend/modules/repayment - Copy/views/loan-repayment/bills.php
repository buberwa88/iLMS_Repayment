<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use frontend\modules\repayment\models\EmployedBeneficiary;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bills';
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
                        'label' => 'Employer Loan Payment',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment/loan-bills-employer']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '1',
                    ],
					[
                        'label' => 'Beneficiary',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment/loan-bills-beneficiary']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '1',
                    ],
					[
                        'label' => 'Employer Penalty',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['employer/employer-penalty-bill']) . '" width="100%" height="600px" style="border: 0"></iframe>',
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