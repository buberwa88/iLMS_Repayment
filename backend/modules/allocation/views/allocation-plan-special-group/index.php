<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationFrameworkSpecialGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Framework Special Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-framework-special-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Allocation Framework Special Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'special_group_id',
            'allocation_framework_id',
            'group_name',
            'applicant_source_table',
            'applicant_souce_column',
            // 'applicant_source_value',
            // 'operator',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
