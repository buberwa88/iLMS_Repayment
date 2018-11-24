<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

//$this->title ="Batch Details";
 
?>
<div class="fixedassets-view">
<div class="box box-info">
            <div class="box-header with-border">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
           
<?php
$registeredBeneficiary= $this->render('/loan-beneficiary/index', [
                                'searchModel' => $searchModelLoanBeneficiary,
								'dataProvider' => $dataProviderLoanBeneficiary,
                               
                            ]);	
/*							
$allBeneficiaries= $this->render('beneficiariesFromDisbursement', [
                                'searchModel' =>$searchModelDisbursementSearch,
								'dataProvider' => $dataProviderAllBeneficiaryFromDisbursement,
                               
                            ]);
							*/
							
echo TabsX::widget([
    'items' => [
        [
            'label' => 'Pending Registered Beneficiaries',
            'content' =>$registeredBeneficiary,
			'options' => ['id' => 'registered_beneficiary_tab'],
            //'id' => '4',
			'active' => ($activeTab == 'registered_beneficiary_tab'),
        ],		
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
?>
                             </div>
                   
                </div>   