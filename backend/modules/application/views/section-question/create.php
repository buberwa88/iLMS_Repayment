<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\SectionQuestion $model
 */

$this->title = 'Create Section Question';
$this->params['breadcrumbs'][] = ['label' => 'Section Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-question-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
