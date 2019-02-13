<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Verifications Assignments';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-assignment-index">
<div class="panel panel-info">
    <div class="panel-heading">
       
    </div>
        <div class="panel-body">
    <?php
            echo TabsX::widget([
                'items' => [
                    /*
                    [
                        'label' => 'Assign',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['verification-assignment/assign-applications']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '2',
                    ],
                     */
                     

                    [
                        'label' => 'Basic Details',
                        'content' => $this->render('student_basic_details', ['model' => $model]),
                        'id' => 'atab1',
                        'active' => ($active == 'atab1') ? true : false,
                    ],
               [
                        'label' => 'Student Associates',
                        'content' =>$this->render('guaranto_details', ['dataProvider' =>$dataProviderApplicantAssociate,'searchModel'=>$searchModelApplicantAssociate]),
                        'id' => 'atab2',
                        'active' => ($active == 'atab2') ? true : false,
                    ],
                    /*
                    [
                        'label' => 'Verification Details',
                        'content' => $this->render('view_attachments', ['dataProvider' =>$dataProviderApplicantAttachment,'searchModel'=>$searchModelApplicantAttachment,'application_id'=>$application_id]),
                        'id' => 'atab3',
                        'active' => ($active == 'atab3') ? true : false,
                    ],
                     * 
                     */
                    [
                        'label' => 'Education Details',
                        'content' => $this->render('education', ['dataProvider' =>$dataProviderEducation,'searchModel'=>$searchModeleducation]),
                        'id' => 'atab3',
                        'active' => ($active == 'atab3') ? true : false,
                    ],
                     
                     
                    
                ],
                'position' => TabsX::POS_ABOVE,
                'bordered' => true,
                'encodeLabels' => false
            ]);
            ?>
</div>
  </div>
</div>
