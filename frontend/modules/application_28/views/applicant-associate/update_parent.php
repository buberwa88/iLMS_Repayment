<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantAssociate */
 $sex=$model->sex;
       if($sex=="M"){
       $position="Father"  ;
       $sex='M';
       }
       else{
       $position="Mother "  ;  
       $sex='F';
       }
$this->title = "Update   $position Details: ";
$this->params['breadcrumbs'][] = ['label' => 'my application', 'url' => ['default/my-application-index']];
$this->params['breadcrumbs'][] = ['label' => "parents details", 'url' => ['parent-view', 'id' => $model->applicant_associate_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="applicant-associate-update">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form_parent', [
                'model' => $model,
                   'position'=>$position,
                   'sex'=>$sex
            ])
            ?>

        </div>
    </div>
</div>
