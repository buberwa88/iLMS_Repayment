<?php
//Yii::$app->request->queryParams['ApplicationSearch']["date_verified"];
if($searchModel->date_verified !='' && $searchModel->date_verified2 !=''){
            $searchReportsDateVerified=' AND application.date_verified >='."\"".$searchModel->date_verified." 00:00:00"."\"".' AND application.date_verified <='."\"".$searchModel->date_verified2." 23:59:59"."\"";
        }else if($searchModel->date_verified !='' && $searchModel->date_verified2 ==''){
            $searchReportsDateVerified=' AND application.date_verified >='.$searchModel->date_verified." 00:00:00";
        }else if($searchModel->date_verified =='' && $searchModel->date_verified2 !=''){
            $searchReportsDateVerified=' AND application.date_verified <='.$searchModel->date_verified2." 23:59:59";
        }else{
          $searchReportsDateVerified="";  
        }
        if(empty($searchModel->f4indexno)){$searchReports1="";}else{$searchReports1=' AND applicant.f4indexno like "%'.$searchModel->f4indexno.'%"';}
        if(empty($searchModel->applicant_category)){$applicant_category="";}else{$applicant_category=' AND application.applicant_category_id="'.$searchModel->applicant_category.'"';}
        if(empty($searchModel->assignee)){$assignee="";}else{$assignee=' AND application.assignee="'.$searchModel->assignee.'"';}
        if(empty($searchModel->sex)){$sex="";}else{$sex=' AND applicant.sex="'.$searchModel->sex.'"';}
        if(empty($searchModel->firstName)){$firstName="";}else{$firstName=' AND user.firstName like "%'.$searchModel->firstName.'%"';}
        if(empty($searchModel->middlename)){$middlename="";}else{$middlename=' AND user.middlename like "%'.$searchModel->middlename.'%"';}
        if(empty($searchModel->surname)){$surname="";}else{$surname=' AND user.surname like "%'.$searchModel->surname.'%"';}
        if(empty($searchModel->verification_status)){$verification_status="";}else{$verification_status=' AND application.verification_status="'.$searchModel->verification_status.'"';}
        if(empty($searchModel->verification_comment)){$verification_comment="";}else{$verification_comment=' AND applicant_attachment.comment="'.$searchModel->verification_comment.'"';}

        $applicationID = 0;
$searchReports='application.application_id<>'.$applicationID.$searchReportsDateVerified.$searchReports1.$applicant_category.$assignee.$sex.$firstName.$middlename.$surname.$verification_status.$verification_comment;

echo $searchReports;
?>
