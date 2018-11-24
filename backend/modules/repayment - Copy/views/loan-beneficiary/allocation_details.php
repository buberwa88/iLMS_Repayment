<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Verifications Assignments';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-assignment-index">
<div class="panel panel-info">
    <div class="panel-heading">
       
    </div>
        <div class="panel-body">
    <?php
            echo TabsX::widget([
                'items' => [
               [
                        'label' => 'Loan Allocation',
                        'content' =>$this->render('allocated_loan', ['dataProvider' =>$dataProviderAllocatedLoan, $model,'searchModel'=>$searchModelAllocatedLoan]),
                        'id' => 'atab2',
                        'active' => ($active == 'atab2') ? true : false,
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
