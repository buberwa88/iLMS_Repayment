<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ProgrammeGroup */

$this->title = 'Create Programme Group';
$this->params['breadcrumbs'][] = ['label' => 'Programme Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-group-create">
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