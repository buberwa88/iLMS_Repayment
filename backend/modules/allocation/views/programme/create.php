<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Programme */

$this->title = 'Create Programme';
$this->params['breadcrumbs'][] = ['label' => 'Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-create">
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