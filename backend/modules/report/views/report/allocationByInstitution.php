<?php
ini_set('memory_limit', '10000M');
set_time_limit(0);

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;

//echo $this->render('report_header', ['reportName' => $reportName]);
$academicYear='';
?>

<table width="100%">
    <thead>					
        <tr>
            <th style="text-align: left; ">SNo</th>
            <th style="text-align: left; ">INSTITUTION</th>
            <th style="text-align: right; ">ADMISSION</th>
            <th style="text-align: right; ">ADMISSION NON-APPLICANT</th>
            <th style="text-align: right; ">ADMISSION APPLICANT</th>
            <th style="text-align: right; ">ALLOCATED</th>
            <th style="text-align: right; ">%ALLOCATED</th>
            <th style="text-align: right; ">AVERAGE LOAN</th>
        </tr>
    </thead>
    <tbody> 
        <?php
        $count = 0;
        $count2 = 0;
        $total_footer = array();
        $overallAdmission=0;
        $totalhasAdmissionNonApplicant=0;
        $totalhasAdmissionApplicant=0;
        $TotalallocatedStudents=0;
        $totalAllocatedAmount=0;
        foreach ($reportData as $row) {
            $count++;
            
            
            $params = array(
                    ':learning_institution_id' => $row['learning_institution_id'],
                    //':academic_year_id' => $row['academic_year_id'],
                    //':allocation_type' => $row['allocation_type'],
                    //':study_year' => $row['study_year']
                );
                     $learning_institution_id=$row['learning_institution_id'];
                     $academicYear=$row['academic_year_id'];
                        $AdmissionData=Report::getAdmissionFigure($academicYear,$learning_institution_id);
                    
                    ?>
                    <td style="text-align: right;"><?php echo $amount; ?></td>
                    <?php
                
            
            
            ?> 
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $row['institution_name']; ?></td>
                <td style="text-align: right; "><?php echo $AdmissionData->studentsAdmission; ?></td>
                <td style="text-align: right; "><?php echo $AdmissionData->hasAdmissionNonApplicant; ?></td>
                <td style="text-align: right; "><?php echo $AdmissionData->hasAdmissionApplicant; ?></td>
                <td style="text-align: right; "><?php echo $row['allocatedStudents']; ?></td>
                <td style="text-align: right; "><?php echo number_format((($row['allocatedStudents']/$AdmissionData->studentsAdmission)*100),2);?></td>
                <td style="text-align: right; "><?php echo number_format(($row['allocatedAmount']/$row['allocatedStudents']),2); ?></td>
            </tr>
        <?php
        $overallAdmission +=$AdmissionData->studentsAdmission;
        $totalhasAdmissionNonApplicant +=$AdmissionData->hasAdmissionNonApplicant;
        $totalhasAdmissionApplicant +=$AdmissionData->hasAdmissionApplicant;
        $TotalallocatedStudents +=$row['allocatedStudents'];     
        $totalAllocatedAmount +=$row['allocatedAmount'];
        }
        $percentageHasAllocated=($TotalallocatedStudents/$overallAdmission)*100;
        $averageLoan=$totalAllocatedAmount/$TotalallocatedStudents;
        ?> 
        <tr>
            <th colspan="2">Grand Total</th>
            <th style="text-align: right; "><?php echo number_format(($overallAdmission)); ?></th>
            <th style="text-align: right; "><?php echo number_format(($totalhasAdmissionNonApplicant)); ?></th>
            <th style="text-align: right; "><?php echo number_format(($totalhasAdmissionApplicant)); ?></th>
            <th style="text-align: right; "><?php echo number_format(($TotalallocatedStudents)); ?></th>
            <th style="text-align: right;"><?php echo number_format(($percentageHasAllocated),2); ?></th>
            <th style="text-align: right;"><?php echo number_format(($averageLoan),2); ?></th>
        </tr>

    </tbody>
</table>
<br/><br/><br/>
<?php
//$minMaxValue=Report::getMaxMinAmountAllocated($academicYear);
?>
<table width="100%"><tr><th style="text-align: right; ">AVERAGE</th><th style="text-align: right; ">MAX</th><th style="text-align: right; ">MIN</th></tr>
<tr><td style="text-align: right; "><?php echo number_format((0),2); ?></td><td style="text-align: right; "><?php echo number_format((0),2); ?></td><td style="text-align: right; "><?php echo number_format((0),2); ?></td></tr>
</table>