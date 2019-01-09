<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
?>

<table width="100%">
                    <thead>					
                        <tr>
                            <th style="text-align: left; ">SNo</th>
                            <th style="text-align: left; ">First Name</th>
                            <th style="text-align: left; ">Middle Name</th>
                            <th style="text-align: left; ">Last Name</th>
                            <th style="text-align: left; ">Check #</th>
                            <th style="text-align: left; ">Employer</th>
                            <th style="text-align: left; ">Department</th>
                            <th style="text-align: left; ">Status</th>
                        </tr>
                    </thead>
                    <tbody>
       <?php              
                     $count=0;  
   $rowNo=0;
   foreach($reportData as $row){
       $count++;
       ?>

       <tr>
           <td><?php echo $count; ?></td>
           <td><?php echo $row['first_name']; ?></td>
           <td><?php echo $row['middle_name']; ?></td>
           <td><?php echo $row['surname']; ?></td>
           <td><?php echo $row['check_number']; ?></td>
           <td><?php echo $row['vote_name']; ?></td>
           <td><?php echo $row['sub_vote_name']; ?></td>
           <td><?php

               $statusEmployee = $row['checked_status'];
               if ($statusEmployee == 0) {
               echo "Pending";
               }else if($statusEmployee == 1){
                echo "Beneficiary not onrepayment";
               }else if($statusEmployee == 2){
                   echo "Beneficiary onrepayment";
               }else if($statusEmployee == 3){
                   echo "Nonbeneficiary";
               }else if($statusEmployee == 4){
                   echo "Checked employee onrepayment";
               }
                              ?></td>
                        </tr>
                <?php 
                
   } ?>       
                    </tbody>
                </table>