<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\GvtEmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gvt Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gvt-employee-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gvt Employee', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'gvt_employee',
            'vote_number',
            'vote_name',
            'Sub_vote',
            'sub_vote_name',
            // 'check_number',
            // 'f4indexno',
            // 'first_name',
            // 'middle_name',
            // 'surname',
            // 'sex',
            // 'NIN',
            // 'employment_date',
            // 'created_at',
            // 'payment_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
