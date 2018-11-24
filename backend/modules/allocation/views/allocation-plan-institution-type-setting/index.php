<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationPlanInstitutionTypeSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Plan Institution Type Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-institution-type-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Allocation Plan Institution Type Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'allocation_plan_id',
            'institution_type',
            'student_distribution_percentage',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
