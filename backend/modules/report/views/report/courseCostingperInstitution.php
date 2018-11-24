<?php
ini_set('memory_limit', '10000M');
set_time_limit(0);

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;

//echo $this->render('report_header', ['reportName' => $reportName]);
?>

<table width="100%" style="font-size: 8px!important">
    <thead>					
        <tr>
            <th style="text-align: left; ">SNo</th>
            <th style="text-align: left; ">INSTITUTION</th>
            <th style="text-align: left; ">Coursecode</th>
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
            <th style="text-align: right; ">YoS</th>
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
                <td><?php echo $row['group_code']; ?></td>
                <?php
                ///looping withing the dyamic columns as defined in the header list items
                ///get sub queries items
                $params = array(
                    ':programme_id' => $row['programme_id'],
//                    ':academic_year_id' => $row['academic_year_id'],
//                    ':allocation_type' => $row['allocation_type'],
                    ':year_of_study' => $row['year_of_study']
                );
                $sub_query_items = Report::getSubQueryItemsByRowId($reportSubQuery, $params);
                foreach ($obtainHeaderLitems as $header) {
                    $amount = '';
                    if (count($sub_query_items) > 0) {
                        foreach ($sub_query_items as $sub_query_item) {
                            if (isset($sub_query_item['item_code']) && $header->item_code == $sub_query_item['item_code']) {
                                $amount = number_format($sub_query_item['total_cost']);
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
                    echo $row['year_of_study'];
                    ?>
                </td>
            </tr>
        <?php }
        ?> 
    </tbody>
</table>