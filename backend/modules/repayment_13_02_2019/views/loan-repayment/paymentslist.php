<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use frontend\modules\repayment\models\EmployedBeneficiary;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Re-Payments';
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
                        'label' => 'Employer Rep. Summary',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment/payments-employer']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '1',
                    ],
					[
                        'label' => 'Employer Rep. Details(Ben. Found)',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/paymentsunderemployersknown']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '1',
                    ],
					[
                        'label' => 'Employer Rep. Details(Ben. Unknown)',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/paymentsunderemployersunknown']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '1',
                    ],
					[
                        'label' => 'Rep. Unknown Employer',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/paymentsunknown-employers']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '1',
                    ],
					[
                        'label' => 'Beneficiary Repayment',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment/payments-beneficiary']) . '" width="100%" height="600px" style="border: 0"></iframe>',
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