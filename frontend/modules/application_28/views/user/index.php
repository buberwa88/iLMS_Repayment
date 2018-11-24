<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\application\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            'firstname',
            'middlename',
            'surname',
            'sex',
            // 'username',
            // 'password_hash',
            // 'security_question_id',
            // 'security_answer',
            // 'email_address:email',
            // 'passport_photo',
            // 'phone_number',
            // 'is_default_password',
            // 'status',
            // 'status_comment:ntext',
            // 'login_counts',
            // 'last_login_date',
            // 'date_password_changed',
            // 'auth_key',
            // 'password_reset_token',
            // 'activation_email_sent:email',
            // 'email_verified:email',
            // 'created_at',
            // 'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
