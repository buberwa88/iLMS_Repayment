<?php
 $objPHPExcel = new PHPExcel();
	 
$objPHPExcel->getDefaultStyle()->getFont()->setSize('12');
         
           
	$objPHPExcel->setActiveSheetIndex(0)

				->setCellValue('A1',"S/N")
				->setCellValue('B1',"RegistrationNumber")
				->setCellValue('C1',"f4index#")
				->setCellValue('D1',"Name")
				->setCellValue('E1',"Sex")
				->setCellValue('F1',"YearOfStudy")
				->setCellValue('G1',"ProgrameName")
				->setCellValue('H1',"Status")
			       ->setCellValue('I1',"Comment");
				 	
				
//	$objPHPExcel->getActiveSheet()->getStyle('A4:H4')->getFill()
//				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
//				->getStartColor()->setARGB('FF999999');
	                 $mstari = 2;
	           foreach ($model as $data=>$rows)
	             {  
	                   
	                     $objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$mstari,($mstari-1))
				->setCellValue('B'.$mstari,$rows["RegistrationNumber"])
				->setCellValue('C'.$mstari,$rows["f4index#"])
				->setCellValue('D'.$mstari,$rows["Name"])
				->setCellValue('E'.$mstari, $rows["Sex"])
				->setCellValue('F'.$mstari,$rows["YearOfStudy"])
				->setCellValue('G'.$mstari,$rows["ProgrameName"])
				->setCellValue('H'.$mstari,$rows["STATUS"])
                               ->setCellValue('I'.$mstari,$rows["Comment"]);
				   $mstari++;
                                 
	                 }
	$objPHPExcel->getActiveSheet()->setTitle('student(s)');
	$objPHPExcel->setActiveSheetIndex(0);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);	
	 
           $mstari+=3;
	$objPHPExcel->getActiveSheet()->getStyle('C'.$mstari)->getFont()->setBold(true);
	$objPHPExcel->getDefaultStyle()->getFont()->setSize('10');
           
	 
 
			 
	  
	$objPHPExcel->setActiveSheetIndex(0);	
 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);	
	 
	 		
	// Redirect output to a clients web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="rejected_exam_student.xls"');
	header('Cache-Control: max-age=0');
				
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');

