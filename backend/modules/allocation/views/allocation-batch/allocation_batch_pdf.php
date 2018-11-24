<?php
$model_inst= Yii::$app->db->createCommand("SELECT `learning_institution_id` FROM `allocation` al join application ap on  
                                                 al.`application_id`=ap.`application_id` JOIN programme pr on 
                                                 pr.programme_id=ap.programme_id  WHERE allocation_batch_id='{$modelall->allocation_batch_id}' group by  learning_institution_id")->queryAll();
    
 // print_r($model_inst);
   // exit();
$amount_total=0;
$mpdf=new mPDF('c','A4-L','','',10,5,48,25,10,10); 
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
<body>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%" height="400px">
 <tr>
<td width="20%" style="color:#0000BB; " rowspan="4"><img src="../image/logo/heslb_logo.gif" height="110px"></td>
<td width="70%" align="left" colspan="2" style="border: 0mm solid #888888"><span style="font-size: 14pt; font-weight:bold;color: #17365D; font-family:Times;">HIGHER EDUCATION STUDENTS LOANS BOARD</span><br/><span align="center" style="font-size: 14pt; font-weight:bold;color: #17365D; font-family:Times;margin:auto; display:table;">' . $school->category. '</span></td>
</tr>
<tr>
<td width="100%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;">Plot No. 8, Block No. 46, Sam Nujoma Road, Mwenge,P. O. Box 76068 Dar es Salaam.<br/>Phone : +255-22-2772432/3 Email : info@heslb.go.tz</td>

</tr>
</table>
 <table width="100%" style="font-family: serif;" cellpadding="10">
<tr>
 <td width="50%" style="border: 0mm solid #888888;"><span style="font-size: 12pt; color: #123; font-family: Times;"><span style="font-size: 12pt; color: #123; font-family:Times;">Allocations for Academic Year : <b>'.$modelall->academicYear->academic_year.'</b></span></td>
  <td width="30%" style="border: 0mm solid #888888;">Batch No:</td>
   <td width="20%" style="border: 0mm solid #888888;"><b>'.$modelall->batch_number.'</b></td>
</tr>

</table>

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
 <table class="items1" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
<tbody>';
$i=1;
//print_r($model);<pagebreak sheet-size="A4"/>
//exit();
$learning_institution_ids="M";
$learning_institution_id=$model_insts['learning_institution_id'];
  $amoun_sub=0;
  $page_break=1;
  $model= Yii::$app->db->createCommand("SELECT `firstname`, `middlename`,apl.application_id, `surname`,institution_name,institution_code,u.sex,current_study_year, `f4indexno`,apl.`programme_id`,SUM(`allocated_amount`) as amount_total,`allocation_batch_id`,programme_name,programme_code,pr.learning_institution_id FROM `user` u join applicant ap "
      . "  on u.`user_id`=ap.`user_id` join application apl "
      . "  on apl.`applicant_id`=ap.`applicant_id` "
      . "  join allocation alls on alls.`application_id`=apl.`application_id` join programme pr on pr.`programme_id`=apl.`programme_id` "
      . "   join `learning_institution` li on li.`learning_institution_id`=pr.`learning_institution_id`"
      . "  WHERE allocation_batch_id='{$modelall->allocation_batch_id}' AND pr.learning_institution_id='{$learning_institution_id}'  group by alls.`application_id`,`allocation_batch_id` order by pr.learning_institution_id")->queryAll();
      
foreach($model as $models){
    $model_loan_item=  backend\modules\allocation\models\LoanItem::find()->all();
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
 
  $html.='
    <tr>
<td class="totals" align="center"></td>
<td class="totals"  align="left"><b>INSTITUTION</b></td>
<td class="totals" align="left" colspan="'.$count.'">'.$models["institution_name"].' ('.$models["institution_code"].') </td>
</tr>
<tr>
<td class="totals"  align="left"><b>SN</b></td>
<td class="totals" align="center"><b>INDEX</b></td>
<td class="totals" align="center"><b>NAME</b></td>
<td class="totals" align="center"><b>SEX</b></td>
<td class="totals" align="center"><b>REG NO</b></td>
<td class="totals" align="center"><b>Programme Code</b></td>
<td class="totals" align="center"><b>YoS</b></td>';
//get loan item
foreach($model_loan_item as $model_loan_items){
$html.='<td class="totals" align="center"><b>'.strtoupper($model_loan_items["item_code"]).'</b></td>';
  }
$html.='<td class="totals" align="center"><b>TOTAL AMOUNT</b></td></tr>';
$learning_institution_ids=$models["learning_institution_id"];
     }
$name=$models["firstname"]." ".$models["middlename"]." ".$models["surname"];
$html.='
<tr>
<td class="totals" align="left"><b>'.$i.'</b></td>
<td class="totals" align="center">'.$models["f4indexno"].'</td>
<td class="totals" align="center">'.$name.'</td>
<td class="totals" align="center">'.$models["sex"].'</td>
<td class="totals" align="center"></td>
<td class="totals" align="center">'.$models["programme_code"].'</td>
<td class="totals" align="center">'.$models["current_study_year"].'</td>';
//get loan item
$application_id=$models["application_id"];
foreach($model_loan_item as $model_loan_items){
$amount=getLoanItemAmount($application_id,$model_loan_items["loan_item_id"],$models["allocation_batch_id"]);
$html.='<td class="totals" align="right">'.number_format($amount).'</td>';
 $amount_total+=$amount;
 $amount_sub+=$amount;
 }
$html.='<td class="totals" align="right">'.number_format($models["amount_total"]).'</td>';
$html.='</tr>';
$i++;
$page_break++;
}
 $html.='<tr>
<td class="totals" align="center"></td>
<td class="totals" align="center"><b>Sub Total</b></td>
<td class="totals" align="right" colspan="'.$count.'"><b>'.number_format($amount_sub).'</b></td>
</tr>';
$html.=' 
<tr>
<td class="totals" align="center"></td>
<td class="totals" align="center"><b>Total</b></td>
<td class="totals" align="right" colspan="'.$count.'"><b>'.number_format($amount_total).'</b></td>
</tr></tbody>
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



$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("heslb");
$mpdf->SetAuthor("heslb");
$mpdf->SetWatermarkText("heslb");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$mpdf->WriteHTML($html);
$mpdf->AddPage();
    }
    
$mpdf->Output();
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
?>