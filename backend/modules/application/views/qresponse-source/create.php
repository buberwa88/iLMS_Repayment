<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QresponseSource $model
 */

$this->title = 'Create Response Source';
$this->params['breadcrumbs'][] = ['label' => 'Qresponse Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qresponse-source-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
