<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Tempemplyebasic012457 */

$this->title = 'Create Tempemplyebasic012457';
$this->params['breadcrumbs'][] = ['label' => 'Tempemplyebasic012457s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tempemplyebasic012457-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
