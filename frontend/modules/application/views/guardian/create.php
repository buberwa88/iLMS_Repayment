<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guarantor $model
 */

$this->title = 'Add Guardian';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = ['label' => 'Guardians', 'url' => ['/application/guardian/view']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guarantor-create">

    <?= $this->render('_form', [
        'model' => $model,
        'passport_label' =>'Passport Photo',
    ]) ?>

</div>
