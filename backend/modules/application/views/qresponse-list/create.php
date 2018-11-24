<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QresponseList $model
 */

$this->title = 'Create Question Response';
$this->params['breadcrumbs'][] = ['label' => 'Question Response', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qresponse-list-create">
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

