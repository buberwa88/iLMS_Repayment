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
            <th style="text-align: left; ">SNO</th>
			<th style="text-align: left; ">INSTITUTION</th>
            <th style="text-align: left; ">INSTCODE</th>
            <th style="text-align: right; ">ADMMISSION</th>
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
        $TotalallocatedStudents=0;
        $orignTotalAllocatedAmount=0;
        foreach ($reportData as $row) {
            $count++;
            
            
            $params = array(
                    //':learning_institution_id' => $row['learning_institution_id'],
                    //':academic_year_id' => $row['academic_year_id'],
                    //':allocation_type' => $row['allocation_type'],
                    //':study_year' => $row['study_year']
                );
                      $learning_institution_id=$row['learning_institution_id'];
                      $academicYear=$row['academic_year_id'];
					 //$academicYear=1;
					 $AdmissionData=Report::getAllocatedFromAdmission($learning_institution_id,$academicYear);
                                $totalAllocated = $AdmissionData['totalAllocated'];
                                         $totalAllocatedAmount =Report::getAllocatedAmountPerInstitution($learning_institution_id,$academicYear);
                                         $total_allocated_amount1=$totalAllocatedAmount['total_allocated_amount'];
                                         if($total_allocated_amount1 > 0){
                                             $total_allocated_amount=$total_allocated_amount1;
                                         }else{
                                             $total_allocated_amount=0;
                                         }
                                         $admissionWithNoInstitutions=Report::getAdmissionWithNoInstitution($academicYear);  
                                         
                                        
								//echo $total_allocated_amount ;
								//exit;
                            
                        
                    
                    ?>

                    <?php
                
            
            
            ?> 
            <tr>
                <td style="text-align: left; "><?php echo $count; ?></td>
                <td style="text-align: left; "><?php echo $row['institution_name']; ?></td>
				<td style="text-align: left; "><?php echo $row['institution_code']; ?></td>
				<td style="text-align: right; "><?php echo number_format($row['totalStudents']); ?></td>
				<td style="text-align: right; "><?php echo number_format($totalAllocated); ?></td>
                                <td style="text-align: right; "><?php echo number_format((($totalAllocated/$row['totalStudents'])*100),2); ?></td>
                                <td style="text-align: right; "><?php 
                                if($total_allocated_amount > 0){
                                
                                echo number_format(($total_allocated_amount/$totalAllocated),2); 
                                }else{
                                    echo 0;
                                }
                                ?></td>
            </tr>
        <?php
		$overallAdmission +=$row['totalStudents'];
		$TotalallocatedStudents +=$totalAllocated;
                $orignTotalAllocatedAmount +=$total_allocated_amount;
        }
        $percentageHasAllocated=($TotalallocatedStudents/$overallAdmission)*100;
        $averageLoan=$orignTotalAllocatedAmount/$TotalallocatedStudents;        
        ?> 
        <tr>
            <th colspan="3" style="text-align: left; ">Grand Total</th>
            <th style="text-align: right; "><?php echo number_format(($overallAdmission)); ?></th>
	    <th style="text-align: right; "><?php echo number_format(($TotalallocatedStudents)); ?></th>
            <th style="text-align: right; "><?php echo number_format(($percentageHasAllocated),2); ?></th>
            <th style="text-align: right; "><?php echo number_format(($averageLoan),2); ?></th>
        </tr>
        <?php  
        if($admissionWithNoInstitutions['admissionWithNoInstitutions'] > 0){
        ?>
        <tr>
            <th colspan="3" style="text-align: left; ">STUDENTS MISSING INSTITUTIONS:</th>
            <th style="text-align: right; "><?php echo number_format(($admissionWithNoInstitutions['admissionWithNoInstitutions'])); ?></th>
            <th colspan="3" style="text-align: left; "></th>
        </tr>
        <?php } ?>
    </tbody>
</table>