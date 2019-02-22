<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundContactPersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Refund Contact People';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-contact-person-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Refund Contact Person', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'refund_contact_person_id',
            'refund_application_id',
            'firstname',
            'middlename',
            'surname',
            // 'created_at',
            // 'updated_at',
            // 'phone_number',
            // 'email_address:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
