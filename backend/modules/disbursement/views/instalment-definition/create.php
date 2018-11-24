<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\InstalmentDefinition */

$this->title = 'Create Instalment';
$this->params['breadcrumbs'][] = ['label' => 'Instalment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instalment-definition-create">
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