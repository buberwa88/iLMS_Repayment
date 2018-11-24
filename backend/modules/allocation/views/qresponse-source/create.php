<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\QresponseSource */

$this->title = 'Create Question Response Source';
$this->params['breadcrumbs'][] = ['label' => 'Question Response Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qresponse-source-create">
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