<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\LearningInstitutionContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Learning Institution Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-institution-contact-index">

   <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Register Learning Institution Contact ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           //'learning_institution_id',
            'cp_firstname',
            'cp_middlename',
            'cp_surname',
            'cp_email_address:email',
            // 'cp_phone_number',
            // 'photo',
            // 'category',
            // 'signature',
            // 'is_signator',
            // 'updated_at',
            // 'updated_by',
            // 'created_at',
            // 'is_active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>