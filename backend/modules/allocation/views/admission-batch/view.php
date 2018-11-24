<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmissionBatch */

$this->title ="View Detail";
$this->params['breadcrumbs'][] = ['label' => 'Admission Batch', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admission-batch-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'admission_batch_id',
            'academic_year_id',
            'batch_number',
            'batch_desc',
            'created_at',
           // 'created_by',
        ],
    ]) ?>

</div>
  
