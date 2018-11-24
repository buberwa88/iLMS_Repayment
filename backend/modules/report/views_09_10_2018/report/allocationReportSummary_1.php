<?php
ini_set('memory_limit', '10000M');
set_time_limit(0);
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

echo $this->render('report_header',['reportName'=>$reportName]);
?>

<table width="100%">
                    <thead>					
                        <tr>
                            <th style="text-align: left; ">SNo</th>
                            <th style="text-align: left; ">UNCODE</th>
                            <th style="text-align: left; ">STUDENTS</th>
                            <?php 
                            $obtainHeaderLitems = self::getLoanItemNames();
                            $sn=0;
                            foreach ($obtainHeaderLitems as $header) {  
                            ?>
                            <th style="text-align: left; "><?php echo $header->item_code; ?></th>
                            <?php 
                            $sn++;                            
                            } ?>
                        </tr>
                    </thead>
                    <tbody>       
                    </tbody>
                </table>