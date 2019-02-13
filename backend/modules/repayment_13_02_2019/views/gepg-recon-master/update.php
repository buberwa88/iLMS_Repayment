<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgReconMaster */

$this->title = 'Update Gepg Recon Master: ' . $model->recon_master_id;
$this->params['breadcrumbs'][] = ['label' => 'Gepg Recon Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->recon_master_id, 'url' => ['view', 'id' => $model->recon_master_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gepg-recon-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
