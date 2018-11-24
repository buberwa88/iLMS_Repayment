<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\application\models\ApplicantAssociateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applicant Associates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-associate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Applicant Associate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'applicant_associate_id',
            'application_id',
            'organization_name',
            'firstname',
            'middlename',
            // 'surname',
            // 'sex',
            // 'postal_address',
            // 'phone_number',
            // 'physical_address',
            // 'email_address:email',
            // 'NID',
            // 'occupation_id',
            // 'passport_photo',
            // 'type',
            // 'learning_institution_id',
            // 'ward_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
