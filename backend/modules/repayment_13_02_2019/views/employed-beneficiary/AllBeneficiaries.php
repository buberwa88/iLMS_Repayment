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
$beneficiaryOnly= $this->render('beneficiaries_only', [
                                'searchModel' => $searchModel,
								'dataProvider' => $dataProvider,
                               
                            ]);
$non_beneficiaries_only= $this->render('non_beneficiaries_only', [
                                'searchModelNonBenef' => $searchModelNonBenef,
								'dataProvider' => $dataProviderNonBeneficiary,
                               
                            ]);
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
            'label' => 'All Beneficiaries',
            'content' =>'',
			'options' => ['id' => 'all_beneficiaries_tab'],
            //'id' => '1',
			'active' => ($activeTab == 'all_beneficiaries_tab'),
        ],
		[
            'label' => 'Employed Beneficiaries',
            'content' =>$beneficiaryOnly,
			'options' => ['id' => 'employed_beneficiaries_tab'],
           // 'id' => '2',
			'active' => ($activeTab == 'employed_beneficiaries_tab'),
        ],
        [
            'label' => 'Employed Non-Beneficiaries',
            'content' =>$non_beneficiaries_only,
			'options' => ['id' => 'non_employed_beneficiaries_tab'],
            //'id' => '3',
			'active' => ($activeTab == 'non_employed_beneficiaries_tab'),
        ],
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