<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */
?>
<div class="fixedassets-view">
    <div class="box box-info">
        <div class="box-header with-border">
            <?= Html::a('Add Employee', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Download Template', ['download'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Upload Employees', ['upload-general'], ['class' => 'btn btn-success']) ?>
			<?= Html::a('Institutions Codes', ['learning-institutions-codes'], ['class' => 'btn btn-success']) ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <?php
            $beneficiaryVerified = $this->render('beneficiariesVerified', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

            $non_verified_beneficiaries = $this->render('nonVerifiedEmployee', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProviderNonBeneficiary,
            ]);


            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Confirmed Beneficiaries',
                        'content' => $beneficiaryVerified,
                        'id' => '1',
                    ],
                    [
                        'label' => 'Non-Confirmed Employees',
                        'content' => $non_verified_beneficiaries,
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