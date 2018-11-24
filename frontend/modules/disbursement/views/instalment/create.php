<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\disbursement\models\Instalment */

$this->title = Yii::t('app', 'Create Instalment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Instalments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instalment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
