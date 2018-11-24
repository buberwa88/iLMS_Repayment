<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantAssociate */

 $position="Father";
 $sex='M';
    if($parent_count>0){
        $sex=$parentdata->sex;
       if($sex=="F"){
       $position="Father "  ;
       $sex='M';
       }
       else{
       $position="Mother "  ;  
       $sex='F';
       }   
    }
$this->title = "Add  $position Details ";
$this->params['breadcrumbs'][] = ['label' => 'Parent View', 'url' => ['parent-view']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-associate-create">
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