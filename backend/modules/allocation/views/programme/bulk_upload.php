<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Programme */

$this->title = 'Upload Programmes';
$this->params['breadcrumbs'][] = ['label' => 'Manage Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-create col-md-12">
    <div class="panel panel-info ">
        <div class="panel-heading ">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p><?php echo Html::a('Download Programmes Template', ['download-template'], ['class' => 'btn btn-warning']) ?></p>
            <?=
            $this->render('_form_bulk_upload', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
