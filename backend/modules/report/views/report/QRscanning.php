<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 11/1/18
 * Time: 11:14 AM
 */

ini_set('memory_limit', '-1');
set_time_limit(0);
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\disbursement\Module;

//echo $this->render('report_header',['reportName'=>$reportName]);
?>

<table width="100%">
    <thead>
    <tr>
        <th style="text-align: left; ">S/N</th>
        <th style="text-align: left; ">INDEX #</th>
        <th style="text-align: left; ">STUDENT NAME</th>
        <th style="text-align: left; ">SEX</th>
        <th style="text-align: left; ">BOX FILE #</th>
        <th style="text-align: left; ">SCANNED BY</th>
        <th style="text-align: left; ">DATE SCANNED</th>
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
            <td ><?php echo $row['INDEX']; ?></td>
            <td ><?php echo $row['STUDENT']; ?></td>
            <td ><?php echo $row['SEX']; ?></td>
            <td ><?php echo $row['BOX']; ?></td>
            <td ><?php echo UserInfo($row['SCANNED'],'fullName'); ?></td>
            <td ><?php echo date('D d-M-Y',strtotime($row['DATE'])); ?></td>
        </tr>
        <?php

    }

function UserInfo($id,$field){
    $model= Yii::$app->db->createCommand("SELECT firstname,surname FROM `user` WHERE user_id='{$id}'")->queryOne();
      if(count($model)>0 && $field=='fullName'){
    return $model["firstname"].' '.$model["surname"];
    }
}
	?>
    </tbody>
</table>
