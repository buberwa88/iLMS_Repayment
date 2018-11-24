<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
$stle_header='style="border: 1px solid #000000; border-collapse: collapse;\"';
$stleTitle='style="font-weight:bold;width:100%;\"';
$results= backend\modules\application\models\Application::getVerificationReport($searches,$verification_status,$assignee);
//echo $searches;
//exit;
$searches2="";
       //echo "<p $stleTitle>Verification Report, ".$searches2."</p>";
        $i=1;
        echo '<table width="100%">
          <tr>
          <td width="5%" style="text-align: left;">
        <img class="img" src="../../image/logo/logohelsb_new.jpg" alt="" style="height: 70px;width: 70px;"><br /></b>
            </td>
           <td width="85%" style="margin: 1%;text-align: center;">
            <span style="font-weight: bold; font-size: 14pt;">HIGHER EDUCATION STUDENTS'."'".' LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />
             <span style="font-weight: bold; font-size: 9.4pt;">Verification Report.</span><br />                      
           </td>          
         </tr>
         <tr><td><b><i>Filtering Criteria: </i></b>'.$criteriaSearchV.'</td></tr>
       </table>';
       echo "<table $stle_header>           
       <tr><th $stle_header>SNo</th><th $stle_header>f4indexno</th><th $stle_header>FirstName</th><th $stle_header>MiddleName</th><th $stle_header>LastName</th><th $stle_header>Sex</th><th $stle_header>Category</th><th $stle_header>Status</th><th $stle_header>Comment</th><th $stle_header>Date Verified</th><th $stle_header>Officer</th></tr>";
        foreach($results as $values){
           echo "<tr $stle_header>";
           echo "<td $stle_header>".$i."</td>";
            echo "<td $stle_header>".$values->applicant->f4indexno."</td>";
            echo "<td $stle_header>".$values->applicant->user->firstname."</td>";
            echo "<td $stle_header>".$values->applicant->user->middlename."</td>";
            echo "<td $stle_header>".$values->applicant->user->surname."</td>";
            echo "<td $stle_header>".$values->applicant->sex."</td>";
            echo "<td $stle_header>".$values->applicantCategory->applicant_category."</td>";
            if($values->verification_status==0){$status="Unverified";}else if($values->verification_status==1){$status="Complete";}else if($values->verification_status==2){$status="Incomplete";}else if($values->verification_status==3){$status="Waiting";}else if($values->verification_status==4){$status="Invalid";}else if($values->verification_status==5){$status="Pending";}
            echo "<td $stle_header>".$status."</td>";
            echo "<td $stle_header>";
            $verificationComments = \frontend\modules\application\models\ApplicantAttachment::find()                
                ->where(['application_id'=>$values->application_id])
                ->andWhere(['not',['comment'=>'']])
                ->andWhere(['not',['comment'=>NULL]])->all();
                echo "<table>";
                $checkIfAtleastOneComment=\frontend\modules\application\models\ApplicantAttachment::find()
                        ->where(['application_id'=>$values->application_id])
                        ->andWhere(['not',['comment'=>'']])
                        ->andWhere(['not',['comment'=>NULL]])
                        ->count();
                if($checkIfAtleastOneComment > 0){
                echo "<tr><th>Attachment</th><th>Comment</th></tr>";
                }
            foreach ($verificationComments as $modelApplicantAttachment) {
                if($modelApplicantAttachment->comment > 0){
                  echo"<tr>";  
                  echo "<td><ul><li>".$modelApplicantAttachment->attachmentDefinition->attachment_desc."</li></ul></td>";echo "<td><ul><li>".backend\modules\application\models\VerificationComment::getVerificationComment($modelApplicantAttachment->comment)."</li></ul></td>";  
                  echo "</tr>";
                }else{
                  echo "<td></td>";
                }
            }
            echo"</table>";
            echo "</td>";
            if(!empty($values->date_verified)){
            echo "<td $stle_header>".date("Y-m-d",strtotime($values->date_verified))."</td>";
            }else{
             echo "<td $stle_header>".$values->date_verified."</td>";   
            }
            
            echo "<td $stle_header>".$values->assignee0->firstname." ".$values->assignee0->middlename." ".$values->assignee0->surname."</td>";
            echo "</tr>";
            ++$i;
        }
      echo "</table>";

?>
