<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Education $model
 */

$this->title = 'Update Education: ' . ' ' . $model->education_id;
$this->params['breadcrumbs'][] = ['label' => 'Educations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->education_id, 'url' => ['view', 'id' => $model->education_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="education-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
