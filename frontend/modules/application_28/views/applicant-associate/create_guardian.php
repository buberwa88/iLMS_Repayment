<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantAssociate */

$this->title = 'Add Guardian Details';
$this->params['breadcrumbs'][] = ['label' => 'Guardian View', 'url' => ['guardian-view']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-associate-create">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form_guardian', [
                'model' => $model,
                'application_id'=>$application_id,
            ])
            ?>

        </div>
    </div>
</div>