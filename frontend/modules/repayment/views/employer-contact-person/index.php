<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployerContactPersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employer Contact People';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-contact-person-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employer Contact Person', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'repayment_employer_contact_person_id',
            'employer_id',
            'user_id',
            'created_at',
            'created_by',
            // 'role',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
