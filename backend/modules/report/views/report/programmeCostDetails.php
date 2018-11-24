<?php
ini_set('memory_limit', '10000M');
set_time_limit(0);

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;

//echo $this->render('report_header', ['reportName' => $reportName]);
?>

<table width="100%">
    <thead>					
        <tr>
            <th style="text-align: left; ">SNo</th>
            <th style="text-align: left; ">INSTITUTION</th>
            <th style="text-align: left; ">PROGRAMME</th>
            <th style="text-align: left; ">PCODE HESLB</th>          
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
                <td style="text-align: left;"><?php echo $row['programme_name']."-".$row['programme_code']; ?></td>
                <td style="text-align: left;"><?php echo $row['group_code']; ?></td>
                <!--<td style="text-align: left;"><?php //echo $row['programme_code']; ?></td>-->
                </tr>
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
                ?>
                    <tr>
                        <th></th>
                        <th style="text-align: right;">Loan Item</th>
                        <th style="text-align: left;">Amount</th>
                        <th></th>                        
                        </tr>
                <?php
                            foreach ($sub_query_items as $sub_query_item) {                  
                ?>
                        <tr>
                            <td></td>
                        <td style="text-align: right;"><?php echo $sub_query_item['item_name']; ?></td>
                        <td style="text-align: left;"><?php echo number_format($sub_query_item['total_cost']); ?></td>
                        <td></td>
                        </tr>
                        <?php
                    }
                
                ?>
                      
            
        <?php }
        ?> 
    </tbody>
</table>