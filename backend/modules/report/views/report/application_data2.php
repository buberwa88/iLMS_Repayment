<?php
ini_set('memory_limit', '10000M');
set_time_limit(0);
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

//echo $this->render('report_header',['reportName'=>$reportName]);
?>

<table width="100%">
                    <thead>					
                        <tr>
                            <th style="text-align: left; ">SNo</th>
                            <th style="text-align: left; ">f4indexno</th>
                            <th style="text-align: left; ">application_id</th>
                        </tr>
                    </thead>
                    <tbody>
       <?php              
                     $count=0;  
   $rowNo=0;
   foreach($reportData as $row){
      $count++;      
           ?>       
              
                        <tr >
                            <td><?php echo $count; ?></td>
                            <td ><?php echo $row['f4indexno']; ?></td> 
                            <td ><?php echo $row['application_id']; ?></td>
                        </tr>
                <?php 
                
   } ?>       
                    </tbody>
                </table>