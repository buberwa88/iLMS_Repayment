<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantAssociate */

//$this->title = 'Add Guarantor Details';
////$this->params['breadcrumbs'][] = ['label' => 'Guarantor View', 'url' => ['guarantor-view']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-associate-create">

            <?=
            $this->render('_form_guarantor', [
                'model' => $model,
                  'modelApplication'=>$modelApplication,
            ])
            ?>

        </div>
   