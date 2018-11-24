<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Institutions Codes';
$this->params['breadcrumbs'][] = ['label' => 'Loan Beneficiaries', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->loan_beneficiary_id, 'url' => ['view', 'id' => $model->loan_beneficiary_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           'institution_name',
           'institution_code',		   
        
		],
		'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode('Institutions Codes') . ' </h3>',
            'type' => 'info',
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['learning-institutions-codes'], ['class' => 'btn btn-info']),
            'showFooter' => true
        ],
    ]);
    ?>
</div>