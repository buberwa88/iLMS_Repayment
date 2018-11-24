<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guarantor $model
 */

$this->title = 'Add Guarantor';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = ['label' => 'Guarantors', 'url' => ['/application/guarantor/view']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guarantor-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
