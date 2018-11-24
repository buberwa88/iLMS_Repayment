<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationFrameworkItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Verification Framework Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-framework-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Verification Framework Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'verification_framework_item_id',
            'verification_framework_id',
            'attachment_definition_id',
            'attachment_desc',
            'verification_prompt',
            // 'created_at',
            // 'created_by',
            // 'is_active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
