<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Tempupload */

$this->title = 'Create Tempupload';
$this->params['breadcrumbs'][] = ['label' => 'Tempuploads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tempupload-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
