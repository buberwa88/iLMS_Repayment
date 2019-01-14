<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
?>
<?php if($exportCategory==1){ ?>
<table width="100%">
                    <thead>					
                        <tr>
                            <th style="text-align: left; ">SNo</th>
                            <th style="text-align: left; ">Employer</th>
                            <th style="text-align: left; ">Payment Date</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
       <?php              
                     $count=0;  
   $rowNo=0;
   $totalAmount=0;
   foreach($reportData as $row){
       $count++;
       ?>

       <tr>
           <td><?php echo $count; ?></td>
           <td><?php echo $row['employer_name']; ?></td>
           <td><?php echo date("Y-m-d",strtotime($row['receipt_date'])); ?></td>
           <td style="text-align: right;"><?php echo number_format($row['amount'],2);
           $totalAmount +=$row['amount'];
           ?></td>
       </tr>
                <?php 
                
   } ?>
       <tr>
           <th style="text-align: left;" colspan="3">Total Amount</th>
           <th style="text-align: right;">
           <?php echo number_format($totalAmount,2); ?>
           </th>
       </tr>
                    </tbody>
                </table>
<?php } ?>
<?php if($exportCategory==2){
    $reportName= str_replace('<strong>','',str_replace('</strong>','',str_replace('<center>','',str_replace('</center>','',str_replace('<BR>',', ',str_replace('<br/>',', ',str_replace('<center/>','',$reportName)))))));
    $objPHPExcelOutput = new \PHPExcel();
    $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcelOutput->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
    $objPHPExcelOutput->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(true);
    $objPHPExcelOutput->setActiveSheetIndex(0);
    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', $reportName);
    $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:Z1', $reportName);

    $rowCount = 2;
    $s_no = 0;
    $totalAmount=0;
    $customTitle = ['SNo', 'Employer', 'Payment Date', 'Amount'];
    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
    foreach($reportData as $row){
        $s_no++;
        $rowCount++;
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $row['employer_name']);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, date("Y-m-d",strtotime($row['receipt_date'])));
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($row['amount'],2));
        $totalAmount +=$row['amount'];
    }
    $rowCountF =$rowCount + 1;
    $objPHPExcelOutput->getActiveSheet()->mergeCells('A'.$rowCountF.':'.'C'.$rowCountF);
    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCountF, 'Total');
    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCountF, number_format($totalAmount,2));

    $objPHPExcelOutput->getActiveSheet()->getStyle('A1:D' . $rowCountF)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
    $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="collection per employer.xls"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
}
?>