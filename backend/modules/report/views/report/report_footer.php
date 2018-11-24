<?php 

  //set default time zone 
 date_default_timezone_set('Africa/Nairobi');
?>
<div class="header" style="border-bottom: 5px solid #fb9337;">


</div>
   <p>
       <span>Created on <?php echo date('l d.m.Y ').' at ',date('H:m:i'); ?> by <b><?php echo Yii::app()->session['FullName'].'</b> [<i>'.Yii::app()->session['TitleName'].'</i>]'; ?></span>
       <span>Precisecom <?php echo Yii::app()->name; ?> &copy; <?php echo date('Y'); ?> - All Rights Reserved.</span>
       </span>
   </p>
    
       