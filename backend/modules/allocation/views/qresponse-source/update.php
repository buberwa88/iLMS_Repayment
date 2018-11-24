<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\QresponseSource */

$this->title = 'Update Question response Source: ';
$this->params['breadcrumbs'][] = ['label' => 'Qresponse Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->qresponse_source_id, 'url' => ['view', 'id' => $model->qresponse_source_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="qresponse-source-update">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>