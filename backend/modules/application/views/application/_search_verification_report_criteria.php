<?php
//Yii::$app->request->queryParams['ApplicationSearch']["date_verified"];
if($searchModel->date_verified !='' && $searchModel->date_verified2 !=''){
            $searchReportsDateVerifiedC='<b>Date Verified From:</b> '.$searchModel->date_verified." ".' <b>To:</b> '.$searchModel->date_verified2;
        }else if($searchModel->date_verified !='' && $searchModel->date_verified2 ==''){
            $searchReportsDateVerifiedC='<b>Date Verified From:</b> '.$searchModel->date_verified;
        }else if($searchModel->date_verified =='' && $searchModel->date_verified2 !=''){            
            $searchReportsDateVerifiedC='<b>Date Verified To:</b> '.$searchModel->date_verified2;
        }else{
          $searchReportsDateVerifiedC="";  
        }
        if(empty($searchModel->f4indexno)){$searchReports1C="";}else{$searchReports1C=',<b>f4indexno like</b> '.$searchModel->f4indexno;}
        if(empty($searchModel->applicant_category)){$applicant_categoryC="";}else{
            $applicant_categoryq=\frontend\modules\application\models\ApplicantCategory::findOne(['applicant_category_id'=>$searchModel->applicant_category])->applicant_category;
            $applicant_categoryC=',<b>Category:</b> '.$applicant_categoryq;}
        if(empty($searchModel->assignee)){$assigneeC="";}else{
            $assigneeC=',<b>Officer:</b> '.$searchModel->assignee0->firstname." ".$searchModel->assignee0->middlename." ".$searchModel->assignee0->surname;}
        if(empty($searchModel->sex)){$sexC="";}else{
            $sexC=',<b>Sex:</b> '.$searchModel->sex;}
        if(empty($searchModel->firstName)){$firstNameC="";}else{
            $firstNameC=',<b>firstName like</b> '.$searchModel->firstName;}
        if(empty($searchModel->middlename)){$middlenameC="";}else{
            $middlenameC=',<b>middlename like</b> '.$searchModel->middlename;}
        if(empty($searchModel->surname)){$surnameC="";}else{
            $surnameC=',<b>LastName like</b> '.$searchModel->surname;}
        if($searchModel->verification_status==''){$verification_statusC="";}else{
            if($searchModel->verification_status==0){
              $status="Unverified";  
            }else if($searchModel->verification_status==0){$status="Complete";}else if($searchModel->verification_status==2){$status="Incomplete";}else if($searchModel->verification_status==3){$status="Waiting";}else if($searchModel->verification_status==4){$status="Invalid";}else if($searchModel->verification_status==5){$status="Pending";}
            $verification_statusC=',<b>Status:</b> '.$status;}
        if(empty($searchModel->verification_comment)){$verification_commentC="";}else{
            $commentq=\backend\modules\application\models\VerificationCommentGroup::findOne(['verification_comment_group_id'=>$searchModel->verification_comment])->comment_group;
            $verification_commentC=',<b>Comment:</b> '.$commentq;}

//$searchReports='application.application_id<>'.$applicationID.$searchReportsDateVerified.$searchReports1.$applicant_category.$assignee.$sex.$firstName.$middlename.$surname.$verification_status.$verification_comment;

$searchReportsC=$searchReportsDateVerifiedC.$searchReports1C.$applicant_categoryC.$assigneeC.$sexC.$firstNameC.$middlenameC.$surnameC.$verification_statusC.$verification_commentC;

echo $searchReportsC;
?>
