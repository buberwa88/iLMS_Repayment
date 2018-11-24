<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Education $model
 */

$this->title = 'Add T-level Education';
//$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
//$this->params['breadcrumbs'][] = ['label' => 'View', 'url' => ['/application/education/olevel-view']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="education-create">
       
    <?= $this->render('_tlevel_form', [
        'model' => $model,
    ]) ?>

</div>
        