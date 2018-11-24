<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending employers bills request list';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-index">

<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'employer_id',
            //'user_id',
            'employer_name',
            'employer_code',
            //'employer_type',
            
        [
        'label'=>'Bill',
        'format' => 'raw',
        'value'=>function ($model) {
        return Html::a('Prepare Bill', ['bill-prepation','employerID'=>$model->employer_id], ['class' => 'btn btn-success']);
        //return Html::a('Prepare Bill', ['bill-prepation'], ['class' => 'btn btn-success']);
        },
       ],
            // 'postal_address',
            // 'phone_number',
            // 'physical_address',
            // 'ward_id',
            // 'email_address:email',
            // 'loan_summary_requested',
            // 'created_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
       </div>
</div>
