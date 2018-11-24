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
            <th style="text-align: left; ">UNCODE</th>
            <th style="text-align: left; ">STUDENTS</th>
            <?php
            $obtainHeaderLitems = Report::getLoanItemNames();
            //var_dump($obtainHeaderLitems);
            //exit;
            $sn = 0;
            foreach ($obtainHeaderLitems as $header) {
                ?>
                <th style="text-align: left; "><?php echo $header->item_code; ?></th>
                <?php
                $sn++;
            }
            ?>
            <th style="text-align: left; ">TOTAL</th>
        </tr>
    </thead>
    <tbody> 
        <?php
        $count = 0;
        $count2=0;
        $totalFooter=0;
        $totalFooter2=0;
        foreach ($reportData as $row) {
            $count++;
            ?>       

            <tr >
                <td><?php echo $count; ?></td>
                <td ><?php echo $row['item_code']; ?></td>
                <td ><?php echo $row['item_code']; ?></td>
                <?php 
                 foreach ($obtainHeaderLitems as $header) {
                     $count3=Report::getLoanItemAmount($header->loan_item_id);
                 ?>
                    <td ><?php echo $count3; ?></td>
            <?php 
            $count2 +=$count3;
            $totalFooter +=$count3;
                 } ?>
                    <td ><?php echo $count2; 
                    $count2=0;
                    ?></td>
            </tr>
            <?php }
        ?> 
            <tr><td colspan="3">TOTAL</td><?php 
                 foreach ($obtainHeaderLitems as $header) {
                 ?>
                    <td ><?php echo $totalFooter; ?></td>
            <?php 
            $totalFooter2 +=$totalFooter;
                 } ?>
            <td ><?php echo $totalFooter2;
                    ?></td>
            </tr>
    </tbody>
</table>