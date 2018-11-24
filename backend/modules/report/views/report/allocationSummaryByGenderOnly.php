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
            <th style="text-align: left; ">GENDER</th>
            <th style="text-align: right; ">ADMISSION</th>
            <th style="text-align: right; ">ALLOCATED</th>
            <th style="text-align: right; ">%ALLOCATED</th>
            <th style="text-align: right; ">% ALLOCATED BY GENDER</th>
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
                    //':learning_institution_id' => $row['learning_institution_id'],
                    //':academic_year_id' => $row['academic_year_id'],
                    //':allocation_type' => $row['allocation_type'],
                    //':study_year' => $row['study_year']
                );

                     $academicYear=$row['academic_year_id'];
                     $studyYear=$row['study_year'];
                        $AdmissionDataByGender=Report::getAdmissionByGender($academicYear,$studyYear);
                    
                    ?>
                    
                    <?php
                $AllocatedFemale=$row['total_female'];
                $AllocatedMale=$row['total_male'];
                $Allocatedother=$row['other'];
                $ADMISSIONFemale=$AdmissionDataByGender['total_female'];
                $ADMISSIONmale=$AdmissionDataByGender['total_male'];
                $ADMISSIONother=$AdmissionDataByGender['other'];
                //$male=$row['total_male'];
            
            
            ?> 
            <tr>
                <td>F</td>
                <td><?php echo $ADMISSIONFemale; ?></td>
                <td><?php echo $AllocatedFemale; ?></td>
                <td><?php echo $AllocatedFemalePercent; ?></td>
                <td><?php echo $AllocateDvsAdmissionFemalePercent; ?></td>
            </tr>
            <tr>
                <td>M</td>
                <td><?php echo $ADMISSIONmale; ?></td>
                <td><?php echo $AllocatedMale; ?></td>
                <td><?php echo $AllocatedMalePercent; ?></td>
                <td><?php echo $AllocateDvsAdmissionMalePercent; ?></td>
            </tr>
            <tr>
                <td>OTHER</td>
                <td><?php echo $ADMISSIONother; ?></td>
                <td><?php echo $Allocatedother; ?></td>
                <td><?php echo $AllocatedOtherPercent; ?></td>
                <td><?php echo $AllocateDvsAdmissionOtherPercent; ?></td>
            </tr>
        <?php
        }
        ?> 
        <tr>
            <th colspan="2">Grand Total</th>
            <th style="text-align: right; "><?php echo ''; ?></th>
            <th style="text-align: right; "><?php echo ''; ?></th>
            <th style="text-align: right; "><?php echo ''; ?></th>
            <th style="text-align: right; "><?php echo ''; ?></th>
            <th style="text-align: right;"><?php echo ''; ?></th>
            <th style="text-align: right;"><?php echo ''; ?></th>
        </tr>

    </tbody>
</table>