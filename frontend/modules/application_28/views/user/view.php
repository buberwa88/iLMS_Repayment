<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\User */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->user_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'firstname',
            'middlename',
            'surname',
            'sex',
            'username',
            'password_hash',
            'security_question_id',
            'security_answer',
            'email_address:email',
            'passport_photo',
            'phone_number',
            'is_default_password',
            'status',
            'status_comment:ntext',
            'login_counts',
            'last_login_date',
            'date_password_changed',
            'auth_key',
            'password_reset_token',
            'activation_email_sent:email',
            'email_verified:email',
            'created_at',
            'created_by',
        ],
    ]) ?>

</div>
