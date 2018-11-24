<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Currency */

$this->title = 'Create Employer Type';
$this->params['breadcrumbs'][] = ['label' => 'Employer Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-type-create">
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