<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guardian $model
 */

$this->title = 'Guardian Details';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = ['label' => 'Guardians', 'url' => ['/application/guardian/view']];
//$this->params['breadcrumbs'][] = ['label' => $model->guarantor_id, 'url' => ['view', 'id' => $model->guarantor_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="guarantor-update">

    <?= $this->render('_form', [
        'model' => $model,
        'passport_label'=>'Passport Photo (Leave blank to retain Exisiting)'
        
    ]) ?>

</div>
