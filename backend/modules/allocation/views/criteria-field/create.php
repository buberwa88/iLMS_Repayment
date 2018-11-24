<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaField */

$this->title = 'Create Criteria Field';
$this->params['breadcrumbs'][] = ['label' => 'Criteria Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-field-create">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
             <?= Html::a('Return Back', ['index', 'id' =>$criteria_id], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
         'criteria_id'=>$criteria_id,
    ]) ?>

</div>
 </div>
</div>
