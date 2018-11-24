<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adjust Payment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">                
    <?php // echo $this->render('_search', ['model' => $searchModel]); 

    ?>
    <h3>Loanees in this Payment.</h3>
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'loan_repayment_id',
            'applicant_id',
            'old_amount',
            'new_amount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
       </div>
</div>
