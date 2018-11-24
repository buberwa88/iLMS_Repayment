<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guarantor $model
 */

$this->title = 'Guarantor Details';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = ['label' => 'Guarantors', 'url' => ['/application/guarantor/view']];
//$this->params['breadcrumbs'][] = ['label' => $model->guarantor_id, 'url' => ['view', 'id' => $model->guarantor_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="guarantor-update">

    <?= $this->render('_form', [
        'model' => $model,
        
    ]) ?>

</div>
