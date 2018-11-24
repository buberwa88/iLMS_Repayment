<?php
ini_set('memory_limit', '10000M');
set_time_limit(0);

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;

echo $this->render('report_header', ['reportName' => $reportName]);
?>

<table width="100%">
    <thead>					
        <tr>
            <th style="text-align: left; ">SNo</th>
            <th style="text-align: left; ">INSTCODE</th>
            <th style="text-align: left; ">PROGRAMME</th>
            <th style="text-align: left; ">P.CODE</th>
            <th style="text-align: left; ">YoS</th>
            <?php
            $obtainHeader = Report::getMaxNumberOfYrOfStudy();
            $yearsOfStudy=$obtainHeader->years_of_study;
            //exit;
            $sn = 0;
            for($i=1;$i<=$yearsOfStudy; $i++) {
                ?>
                <th style="text-align: left; "><?php echo "Y".$i; ?></th>
                <?php
                $sn++;
            }
            ?>            
        </tr>
    </thead>
    <tbody> 
        <?php
        $count = 0;
        $count2 = 0;
        $total_footer = array();

        foreach ($reportData as $row) {
            $count++;
            ?> 
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $row['institution_code']; ?></td>
                <td style="text-align: left;"><?php echo $row['programme_name']; ?></td>
                <td style="text-align: left;"><?php echo $row['programme_code']; ?></td>
                <td style="text-align: center;"><?php echo $row['years_of_study']; ?></td>
                <?php
                ///looping withing the dyamic columns as defined in the header list items
                ///get sub queries items
                $params = array(
                    ':programme_id' => $row['programme_id'],
//                    ':academic_year_id' => $row['academic_year_id'],
//                    ':allocation_type' => $row['allocation_type'],
//                    ':study_year' => $row['study_year']
                );
                $sub_query_items = Report::getSubQueryItemsByRowId($reportSubQuery, $params);
                for($i=1;$i<=$yearsOfStudy; $i++) {
                    $amount =0;
                    if (count($sub_query_items) > 0) {
                        foreach ($sub_query_items as $sub_query_item) {
                            if (isset($sub_query_item['year_of_study']) && $i == $sub_query_item['year_of_study']) {
                                $amount = number_format($sub_query_item['total_cost']);
                            }
                        }
                    }
                    ?>
                    <td style="text-align: right;"><?php echo $amount; ?></td>
                    <?php
                }
                ?>
            </tr>
        <?php }
        ?> 
   </tbody>
</table>