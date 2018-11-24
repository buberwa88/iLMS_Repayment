<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Education $model
 */
//
//$this->title = 'Update Intended Level of Study Details';
//$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
//$this->params['breadcrumbs'][] = ['label' => 'View Level of Study', 'url' => ['/application/application/study-view']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="education-create">
      <div class="panel panel-info">
        <div class="panel-heading">
       
        </div>
        <div class="panel-body">
    <?= $this->render('_study_level', [
        'model' => $model,
    ]) ?>

</div>
      </div>
</div>