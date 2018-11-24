<?php
use yii\helpers\Html;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\Applicant;
use backend\modules\application\models\ApplicationCycle;
use common\models\AcademicYear;

$applicationInst=0;
$user_id = Yii::$app->user->identity->id;
$modelUser = common\models\User::findone($user_id);
$this->title = "Welcome (".strtoupper($modelUser->firstname).' '.strtoupper($modelUser->middlename).' '.strtoupper($modelUser->surname).")";
$this->params['breadcrumbs'][] = 'My Application';
//$checkstatus=  \common\models\Education::find
           $user_id = Yii::$app->user->identity->id;
           $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
           $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
          $parent_count= ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' ")->count();
           $guardian_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GD' ")->count();
          $guarantor_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GA' ")->count();
          
          ##check allication verification status###
          $applicationDetails = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->orderBy(['application_id'=>SORT_DESC])->one();
          $applicationCyleDetails = ApplicationCycle::find()->where("academic_year_id = {$applicationDetails->academic_year_id}")->one();
          ### end check #############################
          
          ###check application cycle academic year####
          $existsIsApplicationAcademicYearActive = AcademicYear::find()->where("is_current = '1' AND academic_year_id={$applicationDetails->academic_year_id}")->count();
          if($existsIsApplicationAcademicYearActive==0){
          $currentAcademicYear2 = AcademicYear::find()->where("is_current = '1'")->one();
          if(ApplicationCycle::find()->where("academic_year_id = {$currentAcademicYear2->academic_year_id}")->exists()){
            $existsInCycle=1;  
          }else{
            $existsInCycle=0;  
          }
          $applicationYearIsCurrent=0; 
          }else{
            $currentAcademicYear2 = AcademicYear::find()->where("is_current = '1'")->one();
          if(ApplicationCycle::find()->where("academic_year_id = {$currentAcademicYear2->academic_year_id}")->exists()){
            $existsInCycle=1;  
          }else{
            $existsInCycle=0;  
          }  
            $applicationYearIsCurrent=1;   
          }
          ### end check #############################
           ?>
<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
 
 <div class="row">
        <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
                <?php 
                if($applicationYearIsCurrent==1){
                if($applicationCyleDetails->application_cycle_status_id==2){
                if($applicationDetails->verification_status==0 && $applicationDetails->loan_application_form_status !=3){ 
                 echo '<label class="label label-warning" style="font-size:15px;\"><i>Your Application is not Submitted</i></label>';   
                    ?>
                <?php }else if($applicationDetails->verification_status >=0 && $applicationDetails->loan_application_form_status==3){
        echo '<label><i>Your Application Verification Status</i></label>&nbsp;&nbsp;&nbsp;&nbsp:&nbsp;&nbsp;&nbsp;&nbsp;'; 
         if($applicationDetails->verification_status==0){
   echo '<label style="color:red;\"><i>Waiting Verification</i></label>';
         }else if($applicationDetails->verification_status==1){
   echo '<label style="color:red;\"><i>Complete</i></label>';          
         }else if($applicationDetails->verification_status==2){
   echo '<label style="color:red;\"><i>Incomplete</i></label>';          
         }else if($applicationDetails->verification_status==3){
   echo '<label style="color:red;\"><i>Waiting</i></label>';          
         }else if($applicationDetails->verification_status==4){
   echo '<label style="color:red;\"><i>Invalid</i></label>';          
         }else if($applicationDetails->verification_status==5){
   echo '<label style="color:red;\"><i>Pending</i></label>';           
         }
       
                }
                }else{
                    $applicationInst=1;
                  ?>
                <h3 class="box-title"><font color='red'>NOTE:IMPORTANT MESSAGE</font></h3>
                <?php
                }
                }else{
                    if($existsInCycle==1){
                    $applicationInst=1;
                  ?>
                <h3 class="box-title"><font color='red'>NOTE:IMPORTANT MESSAGE</font></h3>
                <?php
                }else{
                    $applicationInst=1;
                    ?>
                <h3 class="box-title"><font color='red'>NOTE:IMPORTANT MESSAGE</font></h3>
                <?php
                }}
                    ?>
            </div>
            <!-- /.box-header -->
            <?php 
            if($applicationInst==1){ ?>
            <div class="box-body">
         <div class="box-group" id="accordion">
	 <div class="panel box box-primary">
		  <div class="box-header with-border">
			<h4 class="box-title">
			  <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="" aria-expanded="false">
				Important tips to remember when filling the application
			  </a>
			</h4>
		  </div>
		  <div id="collapseThree" class="panel-collapse collapse in" aria-expanded="true" style="">
                      
			<ol>
                            <li style="padding-top: 7px;">
                                <h4><font color="red"> Please follow the example below of how a  Passport size photo should look like (dimension 150X160 )</font> </h4>
                                <p>
	<img src="image/sample_150x160.jpg" class="user-image" alt="">
	</p>
                            </li>
				<li style="padding-top: 7px;">
					Applicants are advised to certify COPIES of their academic certificates.<br/>
					<i>(Waombaji wanashauriwa kuhakiki vyeti vyao vya elimu)</i>.
				</li>
				<li style="padding-top: 7px;">
					Applicants are advised to bring birth certificates for certification with Registration Insolvency and Trusteeship Agency (RITA).<br/>
					<i>(Waombaji wanashauriwa kuwasilisha vyeti vyao vya kuzaliwa kwa ajili ya kuvihakiki kwa Wakala wa Usajili Ufilisi na Udhamini(RITA))</i>.
				</li>
				<li style="padding-top: 7px;">
					Applicants with deceased parents are advised to bring death certificates for certification with Registration Insolvency and Trusteeship Agency (RITA).<br/>
					<i>(Waombaji ambao wazazi wao wamefariki wanashauriwa kuwasilisha vyeti vya vifo kwa ajili ya kuvihakiki kwa Wakala wa Usajili Ufilisi na Udhamini(RITA)</i>.
				</li>
				<li style="padding-top: 7px;">
					Applicants and their guarantors are reminded to sign all relevant spaces on pages 2 and 5.<br/>
					<i>(Waombaji na wadhamini wao wanakumbushwa kuweka sahihi kwenye ukurasa wa 2 na 5)</i>.
				</li>
				<li style="padding-top: 7px;">
					Applicants are reminded to get their forms be signed and stamped by the Local Government Authorities and Commissioners of Oath/Advocates.<br/>
					<i>(Waombaji wanakumbushwa kuweka sahihi na mihuri ya Serikali za Mitaa na Kamishna wa Kiapo au Wakili)</i>.
				</li>
				<li style="padding-top: 7px;">
					Applicants should upload all necessary attachments plus pages 2 and 5.<br/>
					<i>(Waombaji wanatakiwa kupakia viambatanisho vyote vya muhimu pamoja na kurasa ya 2 na 5)</i>.
				</li>
				<li style="padding-top: 7px;">
					Applicants are advised to keep one printed copy of the application package.<br/>
					<i>(Waombaji wanashauriwa kutunza nakala moja ya maombi)</i>.
				</li>
				<li style="padding-top: 7px;">
					Applicants should observe deadline which is strictly set on 30th June 2018.<br/>
					<i>(Waombaji wanatakiwa wazingatie siku ya ukomo wa maombi ambayo ni tarehe 30 Juni 2018)</i>.
				</li>
				<li style="padding-top: 7px;">
					<b>
						To view/complete your loan application, go to <u>My Application link</u> on the left side.<br/>
						<i>(Kwa kuangalia/kumalizia maombi yako ya mkopo, nenda kwenye <u>My Application</u>)</i>.
					</b>
				</li>
			</ol>
                 
		  </div>
	  </div>
</div>
            </div>
            <?php }
            ?>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
     </div
        </p>
        </div>