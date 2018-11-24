<?php
ini_set('memory_limit', '10000M');
set_time_limit(0);
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;



//echo "TELE"."<br/>";
//echo $id;
?>


<table width="100%" border="0" style="display: table; border:1px solid #aaa; ">
                    <colgroup>
                        <col class="con0" width="10%" />
                        <col class="con1" width="40%" />
                        <col class="con0" width="30%" />
                        <col class="con1" width="10%" />
                        <col class="con0" width="10%" />
                    </colgroup>
                    <thead>
                        <tr style="font-weight:bold; border:1px solid #aaa;">
                            <th style="border: 1px solid #aaa; padding-right: 10px; ">SNo</th>
                            <th style="background-color: #f7f7f7; border: 1px solid #aaa; padding-right: 10px; ">Username</th>
                            <th style="border: 1px solid #aaa; padding-right: 10px; ">First Name</th>
                            <th style="background-color: #f7f7f7; border: 1px solid #aaa; padding-right: 10px; ">Middle Name</th>
                            <th style="border: 1px solid #aaa; padding-right: 10px; " >Last Name</th>
                            <th style="background-color: #f7f7f7; border: 1px solid #aaa; padding-right: 10px; " >Sex</th>
                        </tr>
                    </thead>
                    <tbody>
       <?php              
                     $count=0;  
   $o='background-color: #f7f7f7; border: 1px solid #aaa; padding-right: 10px;';
   $i = 'border: 1px solid #aaa; padding-right: 10px;';

   $rowNo=0;
   foreach($reportData as $row){
      $count++;      
	//echo $row->firstname;
        //exit;
		/*				
      if($count%2 == 0){
         $rowColor = 'style="border: 1px solid #aaa; padding-right: 10px; "';
      } 
      else{
         $rowColor='style="background-color: #f7f7f7; border: 1px solid #aaa; padding-right: 10px; "';
         }  */ 
           ?>       
              
                        <tr style='<?php echo $o; ?>'>
                            <td style="<?php echo $i; ?>"><?php echo $count; ?></td>
                            <td style="<?php echo $o; ?>"><?php echo $row['username']; ?></td> 
                            <td style="<?php echo $i; ?>"><?php echo $row['firstname']; ?></td>
                            <td style="<?php echo $o; ?>"><?php echo $row['middlename']; ?></td>
                            <td style="<?php echo $i; ?>"><?php echo $row['surname']; ?></td>
                            <td style="<?php echo $o; ?>"><?php echo $row['sex']; ?></td>
                        </tr>
                <?php 
                
   } ?>       
                    </tbody>
                </table>