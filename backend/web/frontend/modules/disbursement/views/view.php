<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\disbursement\models\Instalment */

$this->title = $model->instalment_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Instalments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instalment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->instalment_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->instalment_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'instalment_id',
            'instalment',
            'instalment_desc',
            'is_active',
        ],
    ]) ?>

</div>
