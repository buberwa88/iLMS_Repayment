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
            <th style="text-align: left; ">PROGRAM CLUSTER</th>
            <th style="text-align: right; ">ALLOCATED</th>
            <th style="text-align: right; ">%ALLOCATED</th>
        </tr>
    </thead>
    <tbody> 
        <?php
        $count = 0;
        $count2 = 0;
        $total_footer = array();
        $totalD=0;
        $totalhasAdmissionNonApplicant=0;
        $totalhasAdmissionApplicant=0;
        $TotalallocatedStudents=0;
        $totalAllocatedAmount=0;
        $totalPercent=0;
        foreach ($reportData as $row) {
            $count++;
            
            
            $params = array(
                    //':learning_institution_id' => $row['learning_institution_id'],
                    //':academic_year_id' => $row['academic_year_id'],
                    //':allocation_type' => $row['allocation_type'],
                    //':study_year' => $row['study_year']
                );

                     $sub_query_items = Report::getSubQueryItemsByRowId($reportSubQuery, $params);
                        foreach ($sub_query_items as $sub_query_item) {
                                $studTotalkSubQuery = $sub_query_item['students'];
                        }
                $cluster_name=$row['cluster_name'];
                $students=$row['students'];
                $totalD +=$students;
                //$male=$row['total_male'];
            $pecenAllocated=(($students/$studTotalkSubQuery))*100;
            $totalPercent +=$pecenAllocated;
            
            ?> 
            <tr>
                <td style="text-align: left; "><?php echo $cluster_name; ?></td>
                <td style="text-align: right; "><?php echo number_format($students); ?></td>
                <td style="text-align: right; "><?php echo number_format($pecenAllocated,2); ?></td>
            </tr>
        <?php
        }
        ?> 
        <tr>
            <th style="text-align: left; ">Total</th>
            <th style="text-align: right; "><?php echo number_format($totalD); ?></th>
            <th style="text-align: right; "><?php echo number_format($totalPercent); ?></th>
        </tr>

    </tbody>
</table>