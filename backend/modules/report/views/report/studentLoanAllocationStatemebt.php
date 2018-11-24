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
            <th style="text-align: left; ">BATCH #</th>
            <th style="text-align: right; ">AMOUNT</th>          
        </tr>
    </thead>
    <tbody> 
        <?php
        $count = 0;
        $count2 = 0;
        $totalAmount=0;
        $total_footer = array();

        foreach ($reportData as $row) {
            $count++;
            ?> 
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $row['batch_desc']; ?></td>
                <td style="text-align: right;"><?php echo number_format($row['allocated_amount']); ?></td>
                </tr>
                <?php
                ///looping withing the dyamic columns as defined in the header list items
                ///get sub queries items
                $totalAmount +=$row['allocated_amount'];
                $params = array(
                    //':application_id' => $row['application_id'],
                    ':allocation_batch_id' => $row['allocation_batch_id'],
//                    ':allocation_type' => $row['allocation_type'],
//                    ':study_year' => $row['study_year']
                );
                $sub_query_items = Report::getSubQueryItemsByRowId($reportSubQuery, $params);
                ?>
                    <tr>
                        <th></th>
                        <th style="text-align: left;">Loan Item</th>
                        <th style="text-align: right;">Amount</th>
                        <th></th>                        
                        </tr>
                <?php
                            foreach ($sub_query_items as $sub_query_item) {                  
                ?>
                        <tr>
                            <td></td>
                        <td style="text-align: left;"><?php echo $sub_query_item['item_name']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($sub_query_item['allocated_amount']); ?></td>
                        <td></td>
                        </tr>
                        <?php
                    }
                
                ?>
                      
            
        <?php }
        ?> 
        <tr>
            <th style="text-align: left; "></th>
            <th style="text-align: left; ">TOTAL AMOUNT</th>
            <th style="text-align: right; "><?php echo number_format($totalAmount); ?></th>          
        </tr>
    </tbody>
</table>