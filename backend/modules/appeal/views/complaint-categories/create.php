<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategory */

$this->title = 'Create Complaint Category';
$this->params['breadcrumbs'][] = ['label' => 'Complaint Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaint-category-create">
    <div class="panel panel-info">

        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        
        
        <div class="panel-body">
            
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
