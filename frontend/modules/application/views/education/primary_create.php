<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Education $model
 */

$this->title = 'Add Primary Education';
//$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
//$this->params['breadcrumbs'][] = ['label' => 'View Primary Education', 'url' => ['/application/education/primary-view']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
       
        </div>
        <div class="panel-body">
    <?= $this->render('_primary_form', [
        'model' => $model,
    ]) ?>

</div>
      </div>
</div>