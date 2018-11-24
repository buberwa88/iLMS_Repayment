<?php
$reportLabel="batch_" . date("Y_m_d_h_m_s");
foreach ($reportData as $row) {
    
   $allocation_batch_id=$row['allocation_batch_id']; 
   $academic_year=$row['academic_year'];
   $batch_desc=$row['batch_desc'];
   $batch_number=$row['batch_number'];
}

$model_inst= Yii::$app->db->createCommand("SELECT `learning_institution_id` FROM `allocation` al join application ap on  
                                                 al.`application_id`=ap.`application_id` JOIN programme pr on 
                                                 pr.programme_id=ap.programme_id  WHERE allocation_batch_id='{$allocation_batch_id}' group by  learning_institution_id")->queryAll();
    
 // print_r($model_inst);
   // exit();
$amount_total=0;
$header_id=1;
$learning_institution_ids_s=0;

$amount_bottom_array=array();
$mpdf=new mPDF('c','A4-L','','',5,5,30,25,10,10); 
$total_number=0;
$total_applicant=count($model_inst);
  if($total_applicant>0){
    foreach ($model_inst as $model_insts){
$html = '
<html>
<head>
<style>
body {font-family: sans-serif;
	font-size: 10pt;
}
p {	margin: 0pt; }
table.items {
	border: 0mm solid #000000;
}
td { vertical-align: top; }
.items td {
	border-left: 0mm solid #000000;
	border-right: 0mm solid #000000;
}
table thead td { background-color: #EEEEEE;
	text-align: center;
	border: 0mm solid #000000;
	font-variant: small-caps;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #000000;
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}
.items td.cost {
	text-align: "." center;
}
</style>
</head>
';
$i=1;
//print_r($model);<pagebreak sheet-size="A4"/>
//exit();
  $learning_institution_ids="M";
  $learning_institution_id=$model_insts['learning_institution_id'];
  $allocation_batch_id=$allocation_batch_id;
  $amoun_sub=0;
  $page_break=1;
  $model= Yii::$app->db->createCommand("SELECT `firstname`, `middlename`,apl.application_id, `surname`,institution_name,institution_code,u.sex,current_study_year, `f4indexno`,apl.`programme_id`,SUM(`allocated_amount`) as amount_total,`allocation_batch_id`,programme_name,programme_code,pr.learning_institution_id  FROM `user` u join applicant ap "
      . "  on u.`user_id`=ap.`user_id` join application apl "
      . "  on apl.`applicant_id`=ap.`applicant_id` "
      . "  join allocation alls on alls.`application_id`=apl.`application_id` join programme pr on pr.`programme_id`=apl.`programme_id` "
      . "   join `learning_institution` li on li.`learning_institution_id`=pr.`learning_institution_id`"
      . "  WHERE allocation_batch_id='{$allocation_batch_id}' AND pr.learning_institution_id='{$learning_institution_id}'  group by alls.`application_id`,`allocation_batch_id` order by pr.learning_institution_id")->queryAll();
   $page_i=1;   
foreach($model as $models){
    $model_loan_item=  $model= Yii::$app->db->createCommand("SELECT * FROM loan_item join loan_item_detail on loan_item_detail.loan_item_id=loan_item.loan_item_id where  study_level=1 AND loan_item_category='normal' group by loan_item.loan_item_id order by list_order ASC")->queryAll();
  $count=count($model_loan_item)+8;
     if($models["learning_institution_id"]!=$learning_institution_ids){
 /* if($amount_sub>0){
 $html.='<tr>
<td class="totals" align="center"></td>
<td class="totals" align="center"><b>Sub Total</b></td>
<td class="totals" align="right" colspan="'.$count.'"><b>'.number_format($amount_sub).'</b></td>
</tr>';
 $amount_sub=0;
  }*/
 $page_i=1;  
 $page_ii=0;
  $html.='
<body>

<!--mpdf
<htmlpageheader name="myheader">
<center>
<table width="100%" height="400px">
 <tr>
 
<td width="100%" align="center" style="border: 0mm solid #888888"><span style="font-size: 14pt; font-weight:bold;color: #17365D; font-family:Times;">HIGHER EDUCATION STUDENTS LOANS BOARD</span><br/><span align="center" style="font-size: 14pt; font-weight:bold;color: #17365D; font-family:Times;margin:auto; display:table;">' . $school->category. '</span></td>
</tr>
 
</table>
 <table width="100%" style="font-family: serif;" cellpadding="10">
<tr>
 <td width="100%" align="center" style="border: 0mm solid #888888;"><span style="font-size: 13pt; color: #123; font-family: Times;"><span style="font-size: 12pt; color: #123; font-family:Times;">First Year Allocations for '.$batch_desc.' for Academic Year : <b>'.$academic_year.'</b> </span>
Batch No :<b> '.$batch_number.'</b></td>
</tr>
  
</table>
</center>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br />

 <table class="items1" width="100%" style="font-size: 7pt; border-collapse: collapse; " cellpadding="8">
<tbody><thead align="left" style="display: table-header-group">';


$learning_institution_ids=$models["learning_institution_id"];
     }
     if($learning_institution_ids!=$learning_institution_ids_s){
         $html.='
  <tr>
<td align="left" colspan="'.$count.'" style="front-size:18pt;"><b>INSTITUTION : </b> '.$models["institution_name"].' ('.$models["institution_code"].') </td>
</tr>
<tr>
<td class="totals"  align="left"><b>SN</b></td>
<td class="totals" align="center"><b>INDEX</b></td>
<td class="totals" align="left"><b>NAME</b></td>
<td class="totals" align="center"><b>SEX</b></td>
<td class="totals" align="center"><b>REG NO</b></td>
<td class="totals" align="center"><b>Programme Code</b></td>
<td class="totals" align="center"><b>YoS</b></td>';
          //get loan item
         foreach($model_loan_item as $model_loan_items){
             $html.='<td class="totals" align="center"><b>'.strtoupper($model_loan_items["item_code"]).'</b></td>';
         }
         $html.='<td class="totals" align="center"><b>TOTAL AMOUNT</b></td></tr>';
         $learning_institution_ids_s=$learning_institution_ids;
     }
   /* if($header_id==19){
         $header_id=0;
     }*/
$name=$models["firstname"]." ".$models["middlename"]." ".$models["surname"];
$html.='</thead>
<tr>
<td class="totals" align="left"><b>'.$page_i.'</b></td>
<td class="totals" align="left">'.$models["f4indexno"].'</td>
<td class="totals" align="left">'.$name.'</td>
<td class="totals" align="center">'.$models["sex"].'</td>
<td class="totals" align="center"></td>
<td class="totals" align="left">'.getProgrammeCode($models["programme_code"]).'</td>
<td class="totals" align="center">'.$models["current_study_year"].'</td>';
//get loan item
$application_id=$models["application_id"];
$kk=0;
foreach($model_loan_item as $model_loan_items){
    $loan_item_id=$model_loan_items["loan_item_id"];
$amount=getLoanItemAmount($application_id,$model_loan_items["loan_item_id"],$models["allocation_batch_id"]);
$html.='<td class="totals" align="right">'.number_format($amount).'</td>';
 $amount_total+=$amount;
 $amount_sub+=$amount;
 
 //$amount_bottom_array[$loan_item_id]=array_key_exists($amount_bottom_array[$loan_item_id])?$amount_bottom_array[$loan_item_id]:0+$amount;
 //print_r($amount_bottom_array);
 $kk++;
 }
$html.='<td class="totals" align="right">'.number_format($models["amount_total"]).'</td>';
$html.='</tr>';
$i++;
$page_i++;   
$header_id+=1;
$page_break++;
}
$page_ii=$page_i-1;
$total_number+=$page_ii;
//echo "mickidadi";
//echo "<br/>";
//print_r($amount_bottom_array);
$amount_sub_mk=$amount_sub_mks=0;
$html.='<tr>
            <td class="totals" align="center">Total Student: </td>
            <td class="totals" align="center">'.$page_ii.'</td>
            <td class="totals" colspan="5" align="center"><b>Sub Total</b></td>';
foreach($model_loan_item as $model_loan_items){
    $loan_item_id=$model_loan_items["loan_item_id"];
    $amount_sub_mk=getLoanItemAmountSummary($learning_institution_id,$loan_item_id,$allocation_batch_id);
    $html.='<td class="totals" align="right">'.number_format($amount_sub_mk).'</td>';
    $amount_sub_mks+=$amount_sub_mk;
     }
     $html.='<td class="totals" align="right" ><b>'.number_format($amount_sub_mks).'</b></td>
            </tr>';
     if($total_applicant==$total_number){
$html.='
        <tr>
        <td class="totals" align="center"><b>Total</b></td>
        <td class="totals" align="center">'.$total_number.'</td>
        <td class="totals" align="right" colspan="'.$count.'"><b>'.number_format($amount_total).'</b></td>
        </tr>';
     }
$html.='</tbody>
</table> 
</body>
</html>
';
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//exit();
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("heslb");
$mpdf->SetAuthor("heslb");
//$mpdf->SetWatermarkText("heslb");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$mpdf->WriteHTML($html);
$mpdf->AddPage();
    }
}
$mpdf->Output($reportLabel . '.pdf', "D");
exit;

exit;
function getLoanItemAmount($application_id,$loan_item_id,$allocation_batch_id){
    $amount=0;
    $model=  backend\modules\allocation\models\Allocation::find()->where(["application_id"=>$application_id,'loan_item_id'=>$loan_item_id,'allocation_batch_id'=>$allocation_batch_id])->sum("allocated_amount");
    
    if($model>0){
        $amount=$model;
    }
    return $amount;
}
function getLoanItemAmountSummary($learning_institution_id,$loan_item_id,$allocation_batch_id){
    $amount=0;
    $model=Yii::$app->db->createCommand("SELECT SUM(`allocated_amount`) AS amount FROM `allocation` al join application ap on al.`application_id`=ap.`application_id` join programme pr on pr.programme_id=ap.programme_id WHERE allocation_batch_id='{$allocation_batch_id}' AND loan_item_id='{$loan_item_id}' AND learning_institution_id='{$learning_institution_id}'")->queryOne();
   // $model=  backend\modules\allocation\models\Allocation::find()->where(['loan_item_id'=>$loan_item_id,'allocation_batch_id'=>$allocation_batch_id])->sum("allocated_amount");
    
    if($model>0){
        $amount=$model['amount'];
    }
    return $amount;
}
function getProgrammeCode($programme_code){
    $model= Yii::$app->db->createCommand("SELECT `group_code` FROM `programme` join programme_group on programme.programme_group_id=programme_group.programme_group_id  WHERE programme_code='{$programme_code}' limit 1")->queryOne();
      if(count($model)>0){
    return $model["group_code"];
    }
}
?>
