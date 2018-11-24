<?php
$html ='<html>
<head>
<style>
body {font-family: Times;
	font-size: 10pt;
}
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #aaa;
}
td { vertical-align: top; }
.items td {
	border-left: 0.1mm solid #aaa;
	border-right: 0.1mm solid #aaa;
}
table thead td { background-color: #EEEEEE;
	text-align: center;
	border: 0.1mm solid #aaa;
	font-variant: small-caps;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #aaa;
	background-color: #FFFFFF;
	border: 0mm none #aaa;
	border-top: 0.1mm solid #aaa;
	border-right: 0.1mm solid #aaa;
}
.items td.totals {
	text-align: center;
	border: 0.1mm solid #aaa;
}
.items td.cost {
	text-align: "." center;
}
div.container {
    width: 100%;
    border: 1px solid gray;
}

header, footer {
    padding: 1em;
    color: white;
    background-color: black;
    clear: left;
    text-align: center;
}

.nav {
    float: left;
    max-width: 160px;
    margin: 0;
    padding: 1em;
}
.article {
    margin-left: 170px;
    border-left: 1px solid gray;
    padding: 1em;
    overflow: hidden;
}
.column-left{ float: left; width: 30%; }
.column-right{ float: right; width: 69%; }
 
div.vertical
{
 margin-left: -85px;
 position: absolute;
 width: 215px;
 transform: rotate(90deg);
 -webkit-transform: rotate(90deg); /* Safari/Chrome */
 -moz-transform: rotate(90deg); /* Firefox */
 -o-transform: rotate(90deg); /* Opera */
 -ms-transform: rotate(90deg); /* IE 9 */
}

td.vertical
{
 height: 220px;
 line-height: 14px;
 padding-top:10px;
 text-align: left;
}
.items tr:nth-child(odd) {
  background-color: #f1f1f1;
}
.items  tr:nth-child(even) {
  background-color: #ffffff;
}
</style>
</head>
<body>
<!--mpdf
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%" height="400px">
 <tr>
<td width="20%" style="color:#0000BB; " rowspan="4"><img src="../image/logo/logohelsb_new.png" height="110px"></td>
<td width="70%" align="left" colspan="2" style="border: 0mm solid #888888"><span style="font-size: 14pt; font-weight:bold;color: #17365D; font-family:Times;">HIGHER EDUCATION STUDENTS LOANS BOARD</span><br/><span align="center" style="font-size: 14pt; font-weight:bold;color: #17365D; font-family:Times;margin:auto; display:table;">' . $school->category. '</span></td>
</tr>
<tr>
<td width="100%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;">Plot No. 8, Block No. 46, Sam Nujoma Road, Mwenge,P. O. Box 76068 Dar es Salaam.<br/>Phone : +255-22-2772432/3 Email : info@heslb.go.tz</td>

</tr>
</table>
 <table width="100%" style="font-family: serif;" cellpadding="10">
<tr>
 <td width="50%" style="border: 0mm solid #888888;"><span style="font-size: 12pt; color: #123; font-family: Times;"><span style="font-size: 12pt; color: #123; font-family:Times;">Allocations for Academic Year : '.$modelall->academicYear->academic_year.'</span></td>
  <td width="30%" style="border: 0mm solid #888888;">Batch No:</td>
   <td width="20%" style="border: 0mm solid #888888;">'.$modelall->batch_number.'</td>
</tr>

</table>
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;">Acme Trading Co.</span><br />123 Anystreet<br />Your City<br />GD12 4LP<br /><span style="font-family:dejavusanscondensed;">&#9742;</span> 01777 123 567</td>
<td width="50%" style="text-align: right;">Invoice No.<br /><span style="font-weight: bold; font-size: 12pt;">0012345</span></td>
</tr></table>
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
mpdf-->';
$html.='
 <table width="100%" style="font-family: serif;margin-top:50px;margin-bottom:100px;" cellpadding="10" >
 <tr>
<td width="30%" style="color:#0000BB; " rowspan="4"></td>
<td width="70%" align="center" colspan="2" style="border: 0mm solid #888888"><span style="font-size: 14pt; font-weight:bold;color: #17365D; font-family:Times;"></span><br/><span align="center" style="font-size: 14pt; font-weight:bold;color: #17365D; font-family:Times;margin:auto; display:table;"></span></td>
</tr>
<tr>
<td width="30%" style="border: 0mm solid #888888;"></td>
  <td width="40%" style="border: 0mm solid #888888;"></td>
</tr>
</table>
<div class="container1" style="margin-top:25px">
 <div class="column-left1">
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
<tbody>
 ';
$i=1;
//print_r($model);<pagebreak sheet-size="A4"/>
//exit();
$learning_institution_id="M";
  $amoun_sub=0;
foreach($model as $models){
    $model_loan_item=  backend\modules\allocation\models\LoanItem::find()->all();
  $count=count($model_loan_item)+8;
     if($models["learning_institution_id"]!=$learning_institution_id){
  if($amount_sub>0){
 $html.='<tr style="background:#eaf3f6">
<td class="totals" align="center"></td>
<td class="totals" align="center">Sub Total</td>
<td class="totals" align="right" colspan="'.$count.'">'.number_format($amount_sub).' </td>
</tr>';
 $amount_sub=0;
  }
  $html.='
    <tr style="background:#aaa">
<td class="totals" align="center">Sn</td>
<td class="totals" style="background:#C0C0C0" align="left"><b>INSTITUTION</b></td>
<td class="totals" align="left" colspan="'.$count.'">'.$models["institution_name"].' ('.$models["institution_code"].') </td>
</tr>
<tr style="background:#f7f7f7">
<td class="totals" style="background:#C0C0C0" align="left"><b>SN</b></td>
<td class="totals" align="center"><b>INDEX</b></td>
<td class="totals" align="center"><b>NAME</b></td>
<td class="totals" align="center"><b>SEX</b></td>
<td class="totals" align="center"><b>REG NO</b></td>
<td class="totals" align="center"><b>COURSE</b></td>
<td class="totals" align="center"><b>YoS</b></td>
';
//get loan item
foreach($model_loan_item as $model_loan_items){
$html.='<td class="totals" align="center"><b>'.strtoupper($model_loan_items["item_code"]).'</b></td>';
  }
$html.='<td class="totals" align="center"><b>TOTAL AMOUNT</b></td></tr>';
$learning_institution_id=$models["learning_institution_id"];
     }
$name=$models["firstname"]." ".$models["middlename"]." ".$models["surname"];
$html.='
<tr>
<td class="totals" style="background:#C0C0C0" align="left"><b>'.$i.'</b></td>
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
}
 $html.='<tr style="background:#eaf3f6">
<td class="totals" align="center"></td>
<td class="totals" align="center"><b>Sub Total</b></td>
<td class="totals" align="right" colspan="'.$count.'">'.number_format($amount_sub).' </td>
</tr>';
$html.=' 
<tr style="background:#aaa">
<td class="totals" align="center"></td>
<td class="totals" align="center"><b>Total</b></td>
<td class="totals" align="right" colspan="'.$count.'">'.number_format($amount_total).' </td>
</tr></tbody>
</table></div>

 <pagebreak />';
$html.="</body></html>";
 function getLoanItemAmount($application_id,$loan_item_id,$allocation_batch_id){
     $amount=0;
     $model=  backend\modules\allocation\models\Allocation::find()->where(["application_id"=>$application_id,'loan_item_id'=>$loan_item_id,'allocation_batch_id'=>$allocation_batch_id])->sum("allocated_amount");   
     
     if($model>0){
     $amount=$model;
      }
     return $amount;
 }
//end
//end
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//echo $html;
//exit();

$mpdf = new mPDF('c', 'A4', '', '', 5, 5, 5, 30, 30, 50,'L');
//$mpdf = new mPDF('utf-8', 'L');
  //  $mpdf = new mPDF(['mode' => 'utf-8', 'format' => 'A4-L']);
$header = '
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;"><tr>
<td width="33%">Left header p <span style="font-size:14pt;">{PAGENO}</span></td>
<td width="33%" align="center"><img src="sunset.jpg" width="126px" /></td>
<td width="33%" style="text-align: right;"><span style="font-weight: bold;">Right header</span></td>
</tr></table>
';
$headerE = '
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;"><tr>
<td width="33%"><span style="font-weight: bold;">Outer header</span></td>
<td width="33%" align="center"><img src="sunset.jpg" width="126px" /></td>
<td width="33%" style="text-align: right;">Inner header p <span style="font-size:14pt;">{PAGENO}</span></td>
</tr></table>
';

$footer = '<div align="center">See <a href="http://mpdf1.com/manual/index.php">documentation manual</a></div>';
$footerE = '<div align="center">See <a href="http://mpdf1.com/manual/index.php">documentation manual 2</a></div>';


$mpdf->SetHTMLHeader($header,'',TRUE);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("Allocation batch");
$mpdf->SetAuthor("Allocation batch");
 
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$mpdf->WriteHTML($html);


$mpdf->Output();
exit;

 