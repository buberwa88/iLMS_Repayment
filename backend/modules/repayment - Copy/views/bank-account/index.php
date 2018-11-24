<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\BankAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bank Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-account-index">
<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bank Account', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'bank_account_id',
            //'bank_id',
            [
                'attribute'=>'bank_id',
                'value'=>'bank.bank_name',
            ],
            'branch_name',
            'account_name',
            'account_number',
            [
                'attribute'=>'currency_id',
                'value'=>'currency.currency_ref',
            ],
            // 'currency_id',

            ['class' => 'yii\grid\ActionColumn','template'=>'{update}',],
        ],
    ]); ?>
    </div>
       </div>
</div>
