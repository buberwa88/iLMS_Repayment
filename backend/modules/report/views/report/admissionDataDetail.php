<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
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
                            <th style="text-align: left; ">Firstname</th>
                            <th style="text-align: left; ">Middlename</th>
                            <th style="text-align: left; ">LastName</th>
                            <th style="text-align: left; ">gender</th>
                            <th style="text-align: left; ">f4indexno</th>
							<th style="text-align: left; ">f6indexno</th>
							<th style="text-align: left; ">course_code</th>
							<th style="text-align: left; ">institution_name</th>
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
                            <td ><?php echo $row['firstname']; ?></td> 
                            <td ><?php echo $row['middlename']; ?></td>
                            <td ><?php echo $row['surname']; ?></td>
							<td ><?php echo $row['gender']; ?></td>
                            <td ><?php echo $row['f4indexno']; ?></td>
                            <td ><?php echo $row['f6indexno']; ?></td>
							<td ><?php echo $row['course_code']; ?></td>
							<td ><?php echo $row['institution_name']; ?></td>							
                        </tr>						
                <?php 
                
   } ?>    
                    </tbody>
                </table>