<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */
$this->title = 'Loan Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
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
            echo TabsX::widget([
                'items' => [
					
					[
					'label' => 'Loan Beneficiaries',
					'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/beneficiaries-verified']) . '" width="100%" height="600px" style="border: 0"></iframe>',
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