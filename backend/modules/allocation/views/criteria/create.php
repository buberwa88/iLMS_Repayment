<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Criteria */

$this->title = 'Create Criteria';
$this->params['breadcrumbs'][] = ['label' => 'Criterias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-create">
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