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
                            <th style="text-align: left; ">Firstname</th>
                            <th style="text-align: left; ">Middlename</th>
                            <th style="text-align: left; ">Lastname</th>
                            <th style="text-align: left; ">Phone_Number</th>
                            <th style="text-align: left; ">control_number</th>
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
                            <td ><?php echo $row['Firstname']; ?></td> 
                            <td ><?php echo $row['Middlename']; ?></td>
                            <td ><?php echo $row['Lastname']; ?></td>
                            <td ><?php echo $row['Phone_Number']; ?></td>
                            <td ><?php echo $row['control_number']; ?></td>
                        </tr>
                <?php 
                
   } ?>       
                    </tbody>
                </table>