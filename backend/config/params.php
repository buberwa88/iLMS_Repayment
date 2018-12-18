<?php

return [
    'adminEmail' => 'admin@example.com',
    ///list of the possible programme years of study
    'programme_years_of_study' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
//    //contains the list of th priority order for different clusters
    'priority_order_list' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10],
    'loan_items_category' => ['normal' => 'Normal', 'scholarship' => 'Scholarship/Grant'],
    'seconday_school_study_level' => [0 => 'Primary School', 1 => 'O-Level', 2 => 'A-Level'],
    'allocation_maximum_data_to_process' => 30, /// 
	'reportTemplate' =>'../backend/modules/report/views/report/',
	'HESLBlogo' =>'../image/logo/',
    'report_modules' => [
        1 => 'application', 2 => 'allocation', 3 => 'disbursement', 4 => 'repayment', 5 => 'complaint', 6 => 'appleal',	
    ],
	'employeeExcelTemplate' =>'../frontend/web/dwload',
];
