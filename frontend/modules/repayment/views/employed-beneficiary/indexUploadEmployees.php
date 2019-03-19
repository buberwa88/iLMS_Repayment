<?php
//use yii\helpers\Html;
//use kartik\grid\GridView;
//use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\tabs\TabsX;
//use yii\bootstrap\Modal;
use yii\helpers\Url;
use frontend\modules\repayment\models\EmployedBeneficiary;

//use kartik\dialog\Dialog;
//use yii\jui\Dialog;

/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */
$this->title = 'Loan Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <?php
            echo TabsX::widget([
                'items' => [

                    [
                        'label' => 'Active Loan Beneficiaries',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/beneficiaries-verified']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '1',
                    ],
					[
                        'label' => 'Inactive Loan Beneficiaries',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/inative-beneficiaries']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '2',
                    ],
					[
                        'label' => 'Loan Repayment Schedule',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/beneficiaries-payschedule']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '3',
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



