<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\Applicant;
use common\models\AcademicYear;
use backend\modules\application\models\ApplicationCycle;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
            
            <?php 
            $user_id = Yii::$app->user->identity->id;
            $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
            $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->orderBy(['application_id'=>SORT_DESC])->one();
            $sqlquest=Yii::$app->db->createCommand('SELECT count(*) FROM `application_cycle` apc join academic_year ac  on apc.`academic_year_id`=ac.`academic_year_id` WHERE application_cycle_status_out_id=2 AND ac.`academic_year_id`=1')->queryScalar();         
            
            ###check application cycle academic year####
          $currentAcademicYear = AcademicYear::find()->where("is_current = '1'")->one();
          $applicationCyleDetails = ApplicationCycle::find()->where("academic_year_id = {$currentAcademicYear->academic_year_id}")->one();
          if(ApplicationCycle::find()->where("academic_year_id = {$currentAcademicYear->academic_year_id}")->exists()){
            $exists=1;  
          }else{
            $exists=0;  
          }
          ### end check #############################
            ?>
            
    <p>
       <?php 
       if($sqlquest==0){
       if($modelApplication->loan_application_form_status>1&&$modelApplication->loan_application_form_status<3){ ?>
        <?= Html::a('Upload Missing Attachment', ['application/upload-missing-attachment','id'=> $modelApplication->application_id], ['class' => 'btn btn-primary']) ?>
       <?php }else{ ?>
        <?= Html::a('Upload Missing Attachment', ['application/upload-missing-attachment','id'=> $modelApplication->application_id], ['class' => 'btn btn-primary']) ?>
       <?php } }
       if($exists==1 && ($applicationCyleDetails->application_cycle_status_id ==3 || $applicationCyleDetails->application_cycle_status_id ==4 || $applicationCyleDetails->application_cycle_status_id ==1)){
       ?>
        <?= Html::a('Apply', ['new-application'], ['class' => 'btn btn-success']) ?>
       <?php } ?>
    </p>
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'hover' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            /*
                    [
                     'attribute' => 'applicant_category_id',
                        'label'=>'Category',
                        //'width' => '120px',
                        'value' => function ($model) {
                            return $model->applicantCategory->applicant_category;
                        },
                        'format' => 'raw'
                    ],
             * 
             */
                    [
                     'attribute' => 'applicant_category_id',
                        'label'=>'Category',
                        'filter' => \frontend\modules\application\models\Application::dropdownApplicantCateg(),
                        'value' => function($model, $index, $dataColumn) {
                        $roleDropdown=\frontend\modules\application\models\Application::dropdownApplicantCateg();
                           return $roleDropdown[$model->applicant_category_id];
                        },
                    ],
                                
                                [
                     'attribute' => 'academic_year_id',
                        'label'=>'Academic Year',
                        'filter' => \frontend\modules\application\models\Application::dropdownApp(),
                        'value' => function($model, $index, $dataColumn) {
                        $roleDropdown=\frontend\modules\application\models\Application::dropdownApp();
                           return $roleDropdown[$model->academic_year_id];
                        },
                    ],                               
                   [
                     'attribute' => 'verification_status',
                       // 'label'=>"f4 Index #",
                        'vAlign' => 'middle',
                        //'width' => '140px',
                        'value' => function ($model) {
                                   if($model->verification_status ==0){
                                     return Html::label("Unverified", NULL, ['class'=>'label label-default']);
                                    } else if($model->verification_status==1) {
                                        return Html::label("Complete", NULL, ['class'=>'label label-success']);
                                    }
                                   else if($model->verification_status==2) {
                                        return Html::label("Incomplete", NULL, ['class'=>'label label-danger']);
                                    }
                                  else if($model->verification_status==3) {
                                        return Html::label("Waiting", NULL, ['class'=>'label label-warning']);
                                    }else if($model->verification_status==4) {
                                        return Html::label("Invalid", NULL, ['class'=>'label label-warning']);
                                    }else if($model->verification_status==5) {
                                        return Html::label("Pending", NULL, ['class'=>'label label-warning']);
                                    }
                        },
                       'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[0=>"Unverified",1=>'Complete',2=>'Incomplete',3=>'Waiting',4=>'Invalid',5=>'Pending'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],              
            //'academic_year_id',
            //'bill_number',
            ///'control_number',
            // 'receipt_number',
            // 'amount_paid',
            // 'pay_phone_number',
            // 'date_bill_generated',
            // 'date_control_received',
            // 'date_receipt_received',
            // 'programme_id',
            // 'application_study_year',
            // 'current_study_year',
            // 'applicant_category_id',
            // 'bank_account_number',
            // 'bank_account_name',
            // 'bank_id',
            // 'bank_branch_name',
            // 'submitted',
           //  'verification_status',
            // 'needness',
            // 'allocation_status',
            // 'allocation_comment',
            // 'student_status',
            // 'created_at',
             [
               'label'=>'',
               'value'=>function($model){
                  return Html::a("Application Details", ['/application/application/view-application'], ['class'=>'label label-success']);
               },
               'format'=>'raw',
             ],
			 /*
             [
               'label'=>'',
               'value'=>function($model){
                  return Html::a("Verify", ['/application/application/view','id'=>$model->application_id], ['class'=>'label label-primary']);
               },
               'format'=>'raw',
             ],
			 */
          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
