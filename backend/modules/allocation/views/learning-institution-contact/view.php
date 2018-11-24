<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LearningInstitutionContact */

$this->title ='Contact Details';
$this->params['breadcrumbs'][] = ['label' => 'Learning Institution Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-institution-contact-view">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->learning_institution_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->learning_institution_id], [
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
            //'learning_institution_id',
            'cp_firstname',
            'cp_middlename',
            'cp_surname',
            'cp_email_address:email',
            'cp_phone_number',
            'photo',
            'category',
           // 'signature',
           // 'is_signator',
            'updated_at',
           // 'updated_by',
            'created_at',
           // 'is_active',
        ],
    ]) ?>

</div>
</div>
</div>