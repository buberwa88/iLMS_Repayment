<?php
ini_set('memory_limit', '10000M');
set_time_limit(0);

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;

//echo $this->render('report_header', ['reportName' => $reportName]);
?>

<table width="100%" style="font-size: 9pt;">
    <thead>					
        <tr>
            <th style="text-align: left; ">SNo</th>
            <th style="text-align: left; ">UNCODE</th>
            <th style="text-align: left; ">STUDENTS</th>
            <?php
            $obtainHeaderLitems = Report::getLoanItemNames();
            $sn = 0;
            foreach ($obtainHeaderLitems as $header) {
                ?>
                <th style="text-align: right; "><?php echo $header->item_code; ?></th>
                <?php
                $sn++;
            }
            ?>
            <th style="text-align: right; ">TOTAL</th>
        </tr>
    </thead>
    <tbody> 
        <?php
        $count = 0;
        $count2 = 0;
        $total_footer = array();

        foreach ($reportData as $row) {
            $count++;
            $total_footer['students'] +=$row['total_applicants'];
            ?> 
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $row['institution_code']; ?></td>
                <td style="text-align: center;"><?php echo $row['total_applicants']; ?></td>
                <?php
                ///looping withing the dyamic columns as defined in the header list items
                ///get sub queries items
                $params = array(
                    ':learning_institution_id' => $row['learning_institution_id'],
//                    ':academic_year_id' => $row['academic_year_id'],
//                    ':allocation_type' => $row['allocation_type'],
//                    ':study_year' => $row['study_year']
                );
                $sub_query_items = Report::getSubQueryItemsByRowId($reportSubQuery, $params);
                foreach ($obtainHeaderLitems as $header) {
                    $amount = 0;
                    if (count($sub_query_items) > 0) {
                        foreach ($sub_query_items as $sub_query_item) {
                            if (isset($sub_query_item['item_code']) && $header->item_code == $sub_query_item['item_code']) {
                                $amount = number_format($sub_query_item['allocated_amount']);
                                $total_footer[$header->item_code] +=$sub_query_item['allocated_amount'];
                            }
                        }
                    }
                    ?>
                    <td style="text-align: right;"><?php echo $amount; ?></td>
                    <?php
                }
                ?>
                <td style="text-align: right;">
                    <?php
                    $total_footer['total'] +=$row['total_allocated_amount'];
                    echo number_format($row['total_allocated_amount'])
                    ?>
                </td>
            </tr>
        <?php }
        ?> 
        <tr>
            <th style="text-align: left; "></th>
            <th style="text-align: left; ">TOTAL</th>
            <th style="text-align: center; "><?php echo number_format($total_footer['students']); ?></th>
            <?php
            foreach ($obtainHeaderLitems as $header) {
                $total_per_item =0;
                if (isset($total_footer[$header->item_code])) {
                    $total_per_item = number_format($total_footer[$header->item_code]);
                }
                ?>
                <th style="text-align: right; "><?php echo $total_per_item; ?></th>
                <?php
            }
            ?>
            <th style="text-align: right;">
                <?php
                echo number_format($total_footer['total']);
                ?>
            </th>
        </tr>

    </tbody>
</table>