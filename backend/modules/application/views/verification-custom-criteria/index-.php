<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationCustomCriteriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Verification Custom Criterias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-custom-criteria-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Verification Custom Criteria', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'verification_custom_criteria_id',
            'verification_framework_id',
            'criteria_name',
            'applicant_source_table',
            'applicant_souce_column',
            // 'applicant_source_value',
            // 'operator',
            // 'created_by',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
