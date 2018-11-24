<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmissionBatch */

$this->title = 'Create Admission Students';
$this->params['breadcrumbs'][] = ['label' => 'Admission Batch', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admission-batch-create">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
<p><?php echo Html::a('Download Admission Students Template', ['download-template'], ['class' => 'btn btn-warning']) ?></p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

        </div>
    </div>
</div>
