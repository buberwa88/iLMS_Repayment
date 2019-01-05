<?php

namespace frontend\modules\repayment\controllers;

use Yii;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\EmployedBeneficiarySearch;
use frontend\modules\repayment\models\EmployerSearch;
use frontend\modules\repayment\models\LoanSummary;
use backend\modules\allocation\models\LearningInstitution;
use backend\modules\allocation\models\LearningInstitutionSearch;
use backend\modules\application\models\ApplicantCategory;
use backend\modules\application\models\ApplicantCategorySearch;
use common\components\Controller;
use frontend\modules\repayment\models\Employer;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\modules\application\models\Programme;
use backend\modules\application\models\ProgrammeSearch;

/**
 * EmployedBeneficiaryController implements the CRUD actions for EmployedBeneficiary model.
 */
class EmployedBeneficiaryController extends Controller {

    /**
     * @inheritdoc
     */
    public $layout = "main_private";

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 1) {
            $this->layout = "main_private_beneficiary";
        }

        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;

        //check government employers if had stated salary source
        $employerSalarySource = Employer::getEmployerSalarySource($employerID);
        //end check

        $dataProvider = $searchModel->getVerifiedEmployeesUnderEmployer(Yii::$app->request->queryParams, $employerID);
        $dataProviderNonBeneficiary = $searchModel->getNonVerifiedEmployees(Yii::$app->request->queryParams, $employerID);

        if (isset($_POST['EmployedBeneficiary'])) {
            //CHECKING IF A USER STILL IS HAVING ACTIVE SESSION...
            if (\Yii::$app->user->identity->user_id == '' OR \Yii::$app->user->identity->user_id == 0) {
                unlink('uploads/' . $date_time . $inputFiles1);
                $sms = '<p>Operation did not complete,session expired </p>';
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['upload-error']);
            } else {
                $modelHeader = new EmployedBeneficiary();
                $modelHeader->scenario = 'upload_employees';
                $employerModel = new EmployerSearch();
                $modelHeader->created_by = \Yii::$app->user->identity->user_id;
                $loggedin = $modelHeader->created_by;
                $employer2 = $employerModel->getEmployer($loggedin);
                $employerID = $employer2->employer_id;
            }
            if ($modelHeader->load(Yii::$app->request->post())) {
                $date_time = date("Y_m_d_H_i_s");
                $inputFiles1 = UploadedFile::getInstance($modelHeader, 'employeesFile');
                $modelHeader->employeesFile = UploadedFile::getInstance($modelHeader, 'employeesFile');
                $modelHeader->upload($date_time);
                $inputFiles = 'uploads/' . $date_time . $inputFiles1;

                try {
                    $inputFileType = \PHPExcel_IOFactory::identify($inputFiles);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFiles);
                } catch (Exception $ex) {
                    die('Error');
                }

                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                if (strcmp($highestColumn, "N") == 0 && $highestRow >= 4) {
                    //VALIDATING IF A FILE HAS NO RECORD TO BE DISCARDED...
                    $row = 4;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    $sn = $rowData[0][0];
                    if ($sn == '') {
                        unlink('uploads/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['upload-error']);
                    } else {
                        $objPHPExcelOutput = new \PHPExcel();
                        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
                        $objPHPExcelOutput->setActiveSheetIndex(0);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'EMPLOYEES UPLOAD REPORT');
                        $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:O1', 'EMPLOYEES UPLOAD REPORT');

                        $rowCount = 2;
                        $s_no = 0;
                        $customTitle = ['SNo', 'EMPLOYEE_ID', 'FORM FOUR INDEX NUMBER', 'FIRST NAME', 'MIDDLE NAME', 'SURNAME', 'DATE OF BIRTH(Year-Month-Day)', 'PLACE OF BIRTH(WARD)', 'MOBILE PHONE NUMBER', 'CURRENT NAME IF CHANGED', 'NAME OF INSTITUTION OF STUDY', 'NATIONAL IDENTIFICATION NUMBER(NIN)', 'GROSS SALARY(TZS)', 'GENDER', 'UPLOAD STATUS', 'FAILED REASON'];
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $customTitle[7]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $customTitle[8]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $customTitle[9]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, $customTitle[10]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('L' . $rowCount, $customTitle[11]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('M' . $rowCount, $customTitle[12]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('N' . $rowCount, $customTitle[13]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, $customTitle[14]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, $customTitle[15]);

                        for ($row = 4; $row <= $highestRow; ++$row) {
                            $s_no++;
                            $rowCount++;
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                            $modelHeader = new EmployedBeneficiary();
                            $modelHeader->scenario = 'Uploding_beneficiaries';
                            $modelHeader->employer_id = $employerID;
                            $modelHeader->created_by = \Yii::$app->user->identity->user_id;
                            $modelHeader->employment_status = "ONPOST";
                            $modelHeader->created_at = date("Y-m-d H:i:s");
                            $modelHeader->employee_check_number = EmployedBeneficiary::formatRowData($rowData[0][1]);
                            $modelHeader->employee_f4indexno = EmployedBeneficiary::formatRowData($rowData[0][2]);
                            $modelHeader->employee_FIRST_NAME = EmployedBeneficiary::formatRowData($rowData[0][3]);
                            $modelHeader->employee_MIDDLE_NAME = EmployedBeneficiary::formatRowData($rowData[0][4]);
                            $modelHeader->employee_SURNAME = EmployedBeneficiary::formatRowData($rowData[0][5]);
                            $modelHeader->employee_DATE_OF_BIRTH = EmployedBeneficiary::formatRowData($rowData[0][6]);
                            $modelHeader->employee_PLACE_OF_BIRTH = EmployedBeneficiary::formatRowData($rowData[0][7]);
                            $modelHeader->employee_mobile_phone_no = EmployedBeneficiary::formatRowData($rowData[0][8]);
                            $modelHeader->employee_current_nameifchanged = EmployedBeneficiary::formatRowData($rowData[0][9]);
                            $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY = EmployedBeneficiary::formatRowData($rowData[0][10]);
                            $modelHeader->employee_NIN = EmployedBeneficiary::formatRowData($rowData[0][11]);
                            $modelHeader->basic_salary = EmployedBeneficiary::formatRowData($rowData[0][12]);
                            $modelHeader->sex = EmployedBeneficiary::formatRowData($rowData[0][13]);
                            if ($modelHeader->sex == 'MALE') {
                                $modelHeader->sex = 'M';
                            } else if ($modelHeader->sex == 'FEMALE') {
                                $modelHeader->sex = 'F';
                            }
                            // added 13-02-2018 
                            $modelHeader->f4indexno = $modelHeader->employee_f4indexno;
                            $modelHeader->firstname = $modelHeader->employee_FIRST_NAME;
                            $modelHeader->middlename = $modelHeader->employee_MIDDLE_NAME;
                            $modelHeader->surname = $modelHeader->employee_SURNAME;
                            $modelHeader->date_of_birth = $modelHeader->employee_DATE_OF_BIRTH;
                            $wardName = $modelHeader->employee_PLACE_OF_BIRTH;
                            $modelHeader->place_of_birth = $modelHeader->getWardID($wardName);
                            $modelHeader->phone_number = $modelHeader->employee_mobile_phone_no;
                            $institution_code = $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY;
                            $modelHeader->learning_institution_id = $modelHeader->getLearningInstitutionID($institution_code);
                            $modelHeader->NID = $modelHeader->employee_NIN;

                            $modelHeader->firstname = trim($modelHeader->employee_FIRST_NAME);
                            $checkIsmoney = $modelHeader->basic_salary;
                            $applcantF4IndexNo = $modelHeader->employee_f4indexno;
                            $NIN = $modelHeader->employee_NIN;
                            //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
                            $employeeID = $modelHeader->getApplicantDetails($applcantF4IndexNo, $NIN);
                            $modelHeader->applicant_id = $employeeID->applicant_id;
                            //end check using unique identifiers
                            //check using non-unique identifiers
                            if (!is_numeric($modelHeader->applicant_id)) {
                                $firstname = $modelHeader->employee_FIRST_NAME;
                                $middlename = $modelHeader->employee_MIDDLE_NAME;
                                $surname = $modelHeader->employee_SURNAME;
                                $dateofbirth = $modelHeader->employee_DATE_OF_BIRTH;
                                $placeofbirth = $modelHeader->employee_PLACE_OF_BIRTH;
                                $academicInstitution = $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY;
                                $resultsUsingNonUniqueIdent = $modelHeader->getApplicantDetailsUsingNonUniqueIdentifiers($firstname, $middlename, $surname, $dateofbirth, $placeofbirth, $academicInstitution);
                                $modelHeader->applicant_id = $resultsUsingNonUniqueIdent->applicant_id;
                            }
                            // end check using unique identifiers

                            $modelHeader->employee_id = $modelHeader->employee_check_number;
                            if (!is_numeric($modelHeader->applicant_id)) {
                                $modelHeader->applicant_id = '';
                            }
                            if (!is_numeric($modelHeader->created_by)) {
                                $modelHeader->created_by = 0;
                            }
                            $applicantId = $modelHeader->applicant_id;
                            $employerId = $modelHeader->employer_id;
                            $employeeId = $modelHeader->employee_id;
                            $f4indexno = $modelHeader->employee_f4indexno;
                            $nameChanged = trim($modelHeader->employee_current_nameifchanged);
                            if ($nameChanged == '' OR empty($nameChanged)) {
                                $firstname = $modelHeader->firstname;
                            } else {
                                $firstname = $modelHeader->employee_current_nameifchanged;
                            }
                            $phone_number = $modelHeader->employee_mobile_phone_no;
                            $NID = $modelHeader->employee_NIN;

                            $modelHeader->validate();
                            $reason = '';
                            if ($modelHeader->hasErrors()) {
                                $errors = $modelHeader->errors;
                                foreach ($errors as $key => $value) {
                                    $reason = $reason . $value[0] . '  ';
                                }
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelHeader->employee_id);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelHeader->f4indexno);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelHeader->firstname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelHeader->middlename);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $modelHeader->surname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $modelHeader->date_of_birth);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $wardName);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $modelHeader->phone_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $modelHeader->employee_current_nameifchanged);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, $institution_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('L' . $rowCount, $NID);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('M' . $rowCount, $modelHeader->basic_salary);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('N' . $rowCount, $modelHeader->sex);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, 'UPLOADED FAILED');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, $reason);
                            } else {
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelHeader->employee_id);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelHeader->f4indexno);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelHeader->firstname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelHeader->middlename);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $modelHeader->surname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $modelHeader->date_of_birth);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $wardName);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $modelHeader->phone_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $modelHeader->employee_current_nameifchanged);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, $institution_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('L' . $rowCount, $NID);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('M' . $rowCount, $modelHeader->basic_salary);

                                // check if beneficiary exists in beneficiary table and save
                                $employeeExist = $modelHeader->checkEmployeeExists($applicantId, $employerId, $employeeId);
                                $employeeExistsId = $employeeExist->employed_beneficiary_id;
                                if ($employeeExistsId >= 1) {
                                    $eployee_exists_status = 1;
                                } else {
                                    $eployee_exists_status = 0;
                                    //check if nonApplicant exists in beneficiary table
                                    $nonApplicantFound = $modelHeader->checkEmployeeExistsNonApplicant($f4indexno, $employerId, $employeeId);
                                    $results_nonApplicantFound = $nonApplicantFound->employed_beneficiary_id;
                                    if ($results_nonApplicantFound >= 1) {
                                        $eployee_exists_nonApplicant = 1;
                                    } else {
                                        $eployee_exists_nonApplicant = 0;
                                    }
                                    //end check if nonApplicant Exists 
                                }

                                if ($sn != '' && $eployee_exists_status == 0 && $eployee_exists_nonApplicant == 0) {
                                    $modelHeader->save();
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, 'UPLOADED SUCCESSFUL');
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, 'N/A');
                                } else if ($sn != '' && $eployee_exists_status == 1) {
                                    $modelHeader->updateBeneficiary($checkIsmoney, $employeeExistsId);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, 'UPLOAD FAILED');
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, 'EMPLOYEE EXISTS');
                                } else if ($sn != '' && $eployee_exists_status == 0 && $eployee_exists_nonApplicant == 1) {
                                    $modelHeader->updateBeneficiaryNonApplicant($checkIsmoney, $results_nonApplicantFound, $f4indexno, $firstname, $phone_number, $NID);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, 'UPLOAD FAILED');
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, 'APPLICANT EXISTS');
                                }
                            }
                        }
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:P' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
                        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="Employees Upload Report.xls"');
                        header('Cache-Control: max-age=0');
                        $writer->save('php://output');
                    }
                } else {
                    unlink('uploads/' . $date_time . $inputFiles1);
                    $sms = '<p>Operation failed, file with no records is not allowed</p>';
                    Yii::$app->getSession()->setFlash('error', $sms);
                    return $this->redirect(['upload-error']);
                }
            }
        }
        return $this->render('AllBeneficiaries', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProviderNonBeneficiary' => $dataProviderNonBeneficiary, 'employerSalarySource' => $employerSalarySource, 'employerID' => $employerID,
        ]);
    }

    public function actionUnconfirmedBeneficiariesView() {
        //$this->layout="default_main";
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 1) {
            $this->layout = "main_private_beneficiary";
        }
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $dataProvider = $searchModel->getUnconfirmedBeneficiaries(Yii::$app->request->queryParams, $employerID);
        return $this->render('unconfirmedBeneficiariesView', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUnVerifiedUploadedEmployees() {
        //$this->layout="default_main";
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 1) {
            $this->layout = "main_private_beneficiary";
        }
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $dataProvider = $searchModel->getNonVerifiedEmployees(Yii::$app->request->queryParams, $employerID);
        return $this->render('unVerifiedUploadedEmployees', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUnconfirmedBeneficiariesList() {
        //$this->layout="default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $employedBeneModel = new EmployedBeneficiary();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $dataProvider = $searchModel->getUnconfirmedBeneficiaries2(Yii::$app->request->queryParams, $employerID);
        $verification_status = 1;
        $results = $employedBeneModel->getUnverifiedEmployees($verification_status, $employerID);
        return $this->render('unconfirmedBeneficiariesList', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'totalUnverifiedEmployees' => $results,
        ]);
    }

    public function actionUnVerifiedUploadedEmployeesList() {
        $this->layout = "default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $employedBeneModel = new EmployedBeneficiary();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        //$dataProvider = $searchModel->getUnconfirmedBeneficiaries(Yii::$app->request->queryParams,$employerID); 
        $dataProvider = $searchModel->getNonVerifiedEmployees(Yii::$app->request->queryParams, $employerID);
        $verification_status = 3;
        $results = $employedBeneModel->getUnverifiedEmployees($verification_status, $employerID);
        return $this->render('unVerifiedUploadedEmployeesList', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'totalUnverifiedEmployees' => $results,
        ]);
    }

    public function actionLearningInstitutionsCodes() {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 1) {
            $this->layout = "main_private_beneficiary";
        }
        $searchModelLearningInstitutionSearch = new LearningInstitutionSearch();
        $dataProvider = $searchModelLearningInstitutionSearch->searchEmployerView(Yii::$app->request->queryParams);

        return $this->render('learningInstitutionsCodes', [
                    'searchModel' => $searchModelLearningInstitutionSearch,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployedBeneficiary model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewBeneficiary($id) {
        $this->layout = "default_main";
        return $this->render('viewBeneficiary', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionView($id) {

        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 2) {
            $this->layout = "main_private";
        }
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionViewLoanNonConfirmedBeneficiaries($id) {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 2) {
            $this->layout = "main_private";
        }
        return $this->render('viewLoanNonConfirmedBeneficiaries', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionUploadError() {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 2) {
            $this->layout = "main_private";
        }
        $model = new EmployedBeneficiary();
        return $this->render('upload_error', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new EmployedBeneficiary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 2) {
            $this->layout = "main_private";
        }
        $modelEmployedBeneficiary = new EmployedBeneficiary();
        $searchModelEmployedBeneficiarySearch = new EmployedBeneficiarySearch();
        $modelEmployedBeneficiary->scenario = 'additionalEmployee';
        $employerModel = new EmployerSearch();
        $modelEmployedBeneficiary->created_by = \Yii::$app->user->identity->user_id;
        $loggedin = $modelEmployedBeneficiary->created_by;
        $employer2 = $employerModel->getEmployer($loggedin);
        $modelEmployedBeneficiary->employer_id = $employer2->employer_id;
        $modelEmployedBeneficiary->created_at = date("Y-m-d H:i:s");
        $employerID = $employer2->employer_id;
        $employerSalarySource=$employer2->salary_source;		
        $modelEmployedBeneficiary->verification_status = 0;

        if ($modelEmployedBeneficiary->load(Yii::$app->request->post()) && $modelEmployedBeneficiary->validate()) {
			$generalMatch='';
			$salary_source=$modelEmployedBeneficiary->salary_source;
			$entryYear = $modelEmployedBeneficiary->programme_entry_year;
            $completionYear = $modelEmployedBeneficiary->programme_completion_year;
			$studyLevel = $modelEmployedBeneficiary->programme_level_of_study;
			$f4CompletionYear = $modelEmployedBeneficiary->form_four_completion_year;
			$regNo=$modelEmployedBeneficiary->f4indexno;
			$programmeStudied = $modelEmployedBeneficiary->programme;
			if($salary_source=='central government'){
					//check employer salary source
					if($employerSalarySource==1 OR $employerSalarySource==3){
						$modelEmployedBeneficiary->salary_source=1;
					}else{
						$modelEmployedBeneficiary->salary_source='';
					}
					//end check
							
				}else if($salary_source=='own source'){
					//check employer salary source
					if($employerSalarySource !=1){
						$modelEmployedBeneficiary->salary_source=2;
					}else{
						$modelEmployedBeneficiary->salary_source='';
					}
					//end check					
				}else if($salary_source=='both'){
					//check employer salary source
					if($employerSalarySource==3){
						$modelEmployedBeneficiary->salary_source=3;
					}else{
						$modelEmployedBeneficiary->salary_source='';
					}
					//end check					
				}else{
					$modelEmployedBeneficiary->salary_source='';
				}
                $EntryAcademicYear = $modelEmployedBeneficiary->getEntryYear($entryYear);
                $completionYear2 = substr($completionYear, 2, 4);
                $CompletionAcademicYear = $modelEmployedBeneficiary->getCompletionYear($completionYear2);

                //echo $EntryAcademicYear."<br/>".$CompletionAcademicYear;
                //exit;
                if ($modelEmployedBeneficiary->sex == 'MALE') {
                    $modelEmployedBeneficiary->sex = 'M';
                } else if ($modelEmployedBeneficiary->sex == 'FEMALE') {
                    $modelEmployedBeneficiary->sex = 'F';
                } else {
                    $modelEmployedBeneficiary->sex = '';
                }
            //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
			    $academicInstitution = $modelEmployedBeneficiary->learning_institution_id;
				/*
			    $splitF4Indexno=explode('.',$modelEmployedBeneficiary->f4indexno);
				$f4indexnoSprit1=$splitF4Indexno[0];
				$f4indexnoSprit2=$splitF4Indexno[1];
				$f4indexnoSprit3=$splitF4Indexno[2];
				$regNo=$f4indexnoSprit1.".".$f4indexnoSprit2;
				$f4CompletionYear=$f4indexnoSprit3;
				*/
				$resultsCountExistIndexNo=$modelEmployedBeneficiary->getAllApplicantsCount($regNo,$f4CompletionYear);
				if($resultsCountExistIndexNo == 1){
            $employeeID = $modelEmployedBeneficiary->getApplicantDetails($regNo,$f4CompletionYear, $modelEmployedBeneficiary->NID);
            $modelEmployedBeneficiary->applicant_id = $employeeID->applicant_id;
				}else if($resultsCountExistIndexNo > 1){
			$resultsUsingNonUniqueIdent = $modelEmployedBeneficiary->getApplicantDetailsNonUniqIdentifierF4indexno($regNo,$f4CompletionYear,$modelEmployedBeneficiary->firstname, $modelEmployedBeneficiary->middlename, $modelEmployedBeneficiary->surname, $academicInstitution, $studyLevel, $programmeStudied, $EntryAcademicYear, $CompletionAcademicYear);
               $modelEmployedBeneficiary->applicant_id = $resultsUsingNonUniqueIdent->applicant_id;		
				}else if($resultsCountExistIndexNo==0){
			$modelEmployedBeneficiary->applicant_id='';		
				}
				$match="f4indexno repeated=>".$resultsCountExistIndexNo.", ";
				$generalMatch.=$match;
			//$modelEmployedBeneficiary->learning_institution_id=;
            //check for disbursed amount to employee
            //check using non-unique identifiers
			
			//echo "learning_institution_id ".$academicInstitution."<br/>"."Study Level ".$studyLevel."<br/>"."programmeStudied ".$programmeStudied."<br/>"."EntryAcademicYear ".$EntryAcademicYear."<br/>"."CompletionAcademicYear ".$CompletionAcademicYear;exit;
            if (!is_numeric($modelEmployedBeneficiary->applicant_id) && $modelEmployedBeneficiary->applicant_id < 1 && $modelEmployedBeneficiary->applicant_id == '') {
				$match="f4indexno Mis-match, ";
				$generalMatch.=$match;
				/*
                $resultsUsingNonUniqueIdent = $modelEmployedBeneficiary->getApplicantDetailsUsingNonUniqueIdentifiers($modelEmployedBeneficiary->firstname, $modelEmployedBeneficiary->middlename, $modelEmployedBeneficiary->surname,$academicInstitutionGeneral,$studyLevelGeneral, $programmeStudiedGeneral,$EntryAcademicYearGeneral,$CompletionAcademicYearGeneral);
				*/
				$resultsUsingNonUniqueIdent = $modelEmployedBeneficiary->getApplicantDetailsUsingNonUniqueIdentifiers($modelEmployedBeneficiary->firstname, $modelEmployedBeneficiary->middlename, $modelEmployedBeneficiary->surname, $academicInstitution, $studyLevel, $programmeStudied, $EntryAcademicYear, $CompletionAcademicYear);
                $modelEmployedBeneficiary->applicant_id = $resultsUsingNonUniqueIdent->applicant_id;
                if($resultsUsingNonUniqueIdent->applicant_id==''){
				$match="Other Criteria Mis-match, ";
                $generalMatch.=	$match;				
				}else if($resultsUsingNonUniqueIdent->applicant_id > 0){
				$match="Other Criteria match, ";
                $generalMatch.=	$match;				
				}				
				
            }else{
			$match="f4indexno match, ";
            $generalMatch.=	$match;		
			}
            // end check using unique identifiers

            if (!is_numeric($modelEmployedBeneficiary->applicant_id)) {
                $modelEmployedBeneficiary->applicant_id = '';
            }
            //$applicantId = $model->applicant_id;
            //check if employee is on study
            if ($modelEmployedBeneficiary->applicant_id != '') {
                $employeeOnstudyStatus = $modelEmployedBeneficiary->getEmployeeOnStudyStatus($modelEmployedBeneficiary->applicant_id);
                if ($employeeOnstudyStatus != '') {
                    $modelEmployedBeneficiary->employee_status = 1;
                } else {
                    $modelEmployedBeneficiary->employee_status = 0;
                }
            } else {
                $modelEmployedBeneficiary->employee_status = 0;
            }
            // check for disbursed amount to employee      
            if ($modelEmployedBeneficiary->applicant_id > 0) {
                $resultDisbursed = $modelEmployedBeneficiary->getIndividualEmployeesPrincipalLoan($modelEmployedBeneficiary->applicant_id);
                if ($resultDisbursed == 0) {
                    $modelEmployedBeneficiary->verification_status = 4;
                }
            }
            //end check
			   //check names and education history match
			   if($modelEmployedBeneficiary->applicant_id >0){
				$applicantNameMatchCount=$modelEmployedBeneficiary->getCheckApplicantNamesMatch($modelEmployedBeneficiary->applicant_id,$modelEmployedBeneficiary->firstname, $modelEmployedBeneficiary->middlename, $modelEmployedBeneficiary->surname);
				if($applicantNameMatchCount > 0){
				$match="Employee Names match, ";
                $generalMatch.=	$match;				
				}else{
				$match="Employee Names Mis-match, ";
                $generalMatch.=	$match;				
				}
			   }
				//end check names and education history match
        }
		$modelEmployedBeneficiary->matching=$generalMatch;
        if ($modelEmployedBeneficiary->load(Yii::$app->request->post()) && $modelEmployedBeneficiary->save()) {
            $dataProvider = $searchModelEmployedBeneficiarySearch->getVerifiedEmployeesUnderEmployer(Yii::$app->request->queryParams, $employerID);
            $dataProviderNonBeneficiary = $searchModelEmployedBeneficiarySearch->getNonVerifiedEmployees(Yii::$app->request->queryParams, $employerID);
            $sms = "Employee Added Successful!";
            Yii::$app->getSession()->setFlash('success', $sms);
			return $this->redirect(['index-view-beneficiary']);
			/*
            return $this->render('AllBeneficiaries', [
                        'searchModel' => $searchModelEmployedBeneficiarySearch,
                        'dataProvider' => $dataProvider,
                        'dataProviderNonBeneficiary' => $dataProviderNonBeneficiary,
						
            ]);
			*/
        } else {
            return $this->render('create', [
                        'model' => $modelEmployedBeneficiary,
            ]);
        }
    }

    public function actionUploadGeneral() {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 2) {
            $this->layout = "main_private";
        }
        $modelHeader = new EmployedBeneficiary();
        $modelHeader->scenario = 'Uploding_employed_beneficiaries';
        $employerModel = new EmployerSearch();
        $modelHeader->created_by = \Yii::$app->user->identity->user_id;
        $loggedin = $modelHeader->created_by;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        if ($modelHeader->load(Yii::$app->request->post())) {
            $date_time = date("Y_m_d_H_i_s");
            $inputFiles1 = UploadedFile::getInstance($modelHeader, 'employeesFile');
            $modelHeader->employeesFile = UploadedFile::getInstance($modelHeader, 'employeesFile');
            $modelHeader->upload($date_time);
            $inputFiles = 'uploads/' . $date_time . $inputFiles1;

            try {
                $inputFileType = \PHPExcel_IOFactory::identify($inputFiles);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFiles);
            } catch (Exception $ex) {
                die('Error');
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();


            if (strcmp($highestColumn, "N") == 0 && $highestRow >= 4) {

                $s1 = 1;

                for ($row = 4; $row <= $highestRow; ++$row) {

                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    $modelHeader = new EmployedBeneficiary();

                    $modelHeader->employer_id = $employerID;
                    $modelHeader->created_by = \Yii::$app->user->identity->user_id;
                    $modelHeader->employment_status = "ONPOST";
                    $modelHeader->created_at = date("Y-m-d H:i:s");
                    $sn = $rowData[0][0];
                    $modelHeader->employee_check_number = EmployedBeneficiary::formatRowData($rowData[0][1]);
                    $modelHeader->employee_f4indexno = EmployedBeneficiary::formatRowData($rowData[0][2]);
                    $modelHeader->employee_FIRST_NAME = EmployedBeneficiary::formatRowData($rowData[0][3]);
                    $modelHeader->employee_MIDDLE_NAME = EmployedBeneficiary::formatRowData($rowData[0][4]);
                    $modelHeader->employee_SURNAME = EmployedBeneficiary::formatRowData($rowData[0][5]);
                    $modelHeader->employee_DATE_OF_BIRTH = EmployedBeneficiary::formatRowData($rowData[0][6]);
                    $modelHeader->employee_PLACE_OF_BIRTH = EmployedBeneficiary::formatRowData($rowData[0][7]);
                    $modelHeader->employee_mobile_phone_no = EmployedBeneficiary::formatRowData($rowData[0][8]);
                    $modelHeader->employee_current_nameifchanged = EmployedBeneficiary::formatRowData($rowData[0][9]);
                    $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY = EmployedBeneficiary::formatRowData($rowData[0][10]);
                    $modelHeader->employee_NIN = EmployedBeneficiary::formatRowData($rowData[0][11]);
                    $modelHeader->basic_salary = EmployedBeneficiary::formatRowData($rowData[0][12]);
                    $modelHeader->sex = EmployedBeneficiary::formatRowData($rowData[0][13]);
                    if ($modelHeader->sex == 'MALE') {
                        $modelHeader->sex = 'M';
                    } else if ($modelHeader->sex == 'FEMALE') {
                        $modelHeader->sex = 'F';
                    }

                    // added 13-02-2018 
                    $modelHeader->f4indexno = $modelHeader->employee_f4indexno;
                    $modelHeader->firstname = $modelHeader->employee_FIRST_NAME;
                    $modelHeader->middlename = $modelHeader->employee_MIDDLE_NAME;
                    $modelHeader->surname = $modelHeader->employee_SURNAME;
                    $modelHeader->date_of_birth = $modelHeader->employee_DATE_OF_BIRTH;
                    $wardName = $modelHeader->employee_PLACE_OF_BIRTH;
                    $modelHeader->place_of_birth = $modelHeader->getWardID($wardName);
                    $modelHeader->phone_number = $modelHeader->employee_mobile_phone_no;
                    $institution_code = $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY;
                    $modelHeader->learning_institution_id = $modelHeader->getLearningInstitutionID($institution_code);
                    $modelHeader->NID = $modelHeader->employee_NIN;

                    // end 13-02-2018


                    $modelHeader->firstname = trim($modelHeader->employee_FIRST_NAME);
                    $checkIsmoney = $modelHeader->basic_salary;
                    $applcantF4IndexNo = $modelHeader->employee_f4indexno;
                    $NIN = $modelHeader->employee_NIN;
                    //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
                    $employeeID = $modelHeader->getApplicantDetails($applcantF4IndexNo, $NIN);
                    $modelHeader->applicant_id = $employeeID->applicant_id;
                    //end check using unique identifiers
                    // check for disbursed amount to employee
                    if ($modelHeader->applicant_id > 0) {
                        $resultDisbursed = $modelHeader->getIndividualEmployeesPrincipalLoan($modelHeader->applicant_id);
                        if ($resultDisbursed == 0) {
                            $modelHeader->verification_status = 4;
                        }
                    }
                    //end check		  
                    //check using non-unique identifiers
                    if (!is_numeric($modelHeader->applicant_id)) {
                        $firstname = $modelHeader->employee_FIRST_NAME;
                        $middlename = $modelHeader->employee_MIDDLE_NAME;
                        $surname = $modelHeader->employee_SURNAME;
                        $dateofbirth = $modelHeader->employee_DATE_OF_BIRTH;
                        $placeofbirth = $modelHeader->employee_PLACE_OF_BIRTH;
                        $academicInstitution = $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY;
                        $resultsUsingNonUniqueIdent = $modelHeader->getApplicantDetailsUsingNonUniqueIdentifiers($firstname, $middlename, $surname, $dateofbirth, $placeofbirth, $academicInstitution);
                        $modelHeader->applicant_id = $resultsUsingNonUniqueIdent->applicant_id;
                    }
                    // end check using unique identifiers

                    $modelHeader->employee_id = $modelHeader->employee_check_number;
                    if (!is_numeric($modelHeader->applicant_id)) {
                        $modelHeader->applicant_id = '';
                    }
                    if (!is_numeric($modelHeader->created_by)) {
                        $modelHeader->created_by = 0;
                    }
                    $applicantId = $modelHeader->applicant_id;
                    $employerId = $modelHeader->employer_id;
                    $employeeId = $modelHeader->employee_id;
                    $f4indexno = $modelHeader->employee_f4indexno;
                    $nameChanged = trim($modelHeader->employee_current_nameifchanged);
                    if ($nameChanged == '' OR empty($nameChanged)) {
                        $firstname = $modelHeader->firstname;
                    } else {
                        $firstname = $modelHeader->employee_current_nameifchanged;
                    }
                    $phone_number = $modelHeader->employee_mobile_phone_no;
                    $NID = $modelHeader->employee_NIN;

                    if ($sn != '' AND ( !is_numeric($checkIsmoney) OR $modelHeader->employee_check_number == '' OR $modelHeader->firstname == '' OR
                            $modelHeader->employee_mobile_phone_no == '' OR $modelHeader->employee_FIRST_NAME == '' OR
                            $modelHeader->employee_MIDDLE_NAME == '' OR $modelHeader->employee_SURNAME == '' OR $modelHeader->employee_DATE_OF_BIRTH == '' OR
                            $modelHeader->employee_PLACE_OF_BIRTH == '' OR $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY == '')) {
                        unlink('uploads/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation did not complete, Please check the information in the excel you are trying to upload.'
                                . '<br/><i>The following columns are compulsory.</i>'
                                . '<ul><li>CHECK NUMBER</li><li>FIRST NAME</li><li>MIDDLE NAME</li><li>SURNAME</li>'
                                . '<li>DATE OF BIRTH</li><li>PLACE OF BIRTH</li><li>MOBILE PHONE NUMBER</li>'
                                . '<li>NAME OF INSTITUTION OF STUDY</li>'
                                . '<li>BASIC SALARY(TZS)</li></ul></p>';
                        //Yii::$app->session->setFlash('sms', $sms);
                        //$sms="Information Updated Successful!";
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['upload-error']);
                    }
                    /*
                      if($sn !='' AND ($modelHeader->applicant_id=='' OR $modelHeader->applicant_id==0)){
                      unlink('uploads/'.$date_time.$inputFiles1);
                      $sms = '<p>Operation did not complete, Employee of form four index number, <i><strong>'.$applcantF4IndexNo."</strong></i> ".'not found.</p>';
                      //Yii::$app->session->setFlash('sms', $sms);
                      Yii::$app->getSession()->setFlash('error', $sms);
                      return $this->redirect(['upload-error']);
                      }
                     * 
                     */
                    if ($sn != '' AND ( $modelHeader->created_by == '' OR $modelHeader->created_by == 0)) {
                        unlink('uploads/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation did not complete,session expired </p>';
                        //Yii::$app->session->setFlash('sms', $sms);
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['upload-error']);
                    }
                    if ($sn == '') {
                        unlink('uploads/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
                        //Yii::$app->session->setFlash('sms', $sms);
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['upload-error']);
                    }

                    // check if beneficiary exists in beneficiary table and save
                    $employeeExist = $modelHeader->checkEmployeeExists($applicantId, $employerId, $employeeId);
                    $employeeExistsId = $employeeExist->employed_beneficiary_id;
                    if ($employeeExistsId >= 1) {
                        $eployee_exists_status = 1;
                    } else {
                        $eployee_exists_status = 0;
                        //check if nonApplicant exists in beneficiary table
                        $nonApplicantFound = $modelHeader->checkEmployeeExistsNonApplicant($f4indexno, $employerId, $employeeId);
                        $results_nonApplicantFound = $nonApplicantFound->employed_beneficiary_id;
                        if ($results_nonApplicantFound >= 1) {
                            $eployee_exists_nonApplicant = 1;
                        } else {
                            $eployee_exists_nonApplicant = 0;
                        }
                        //end check if nonApplicant Exists 
                    }

                    if ($applicantId == '') {
                        $modelHeader->NID = $modelHeader->employee_NIN;
                        $modelHeader->f4indexno = $modelHeader->employee_f4indexno;
                        if ($modelHeader->employee_current_nameifchanged != '') {
                            $modelHeader->firstname = $modelHeader->employee_current_nameifchanged;
                        } else {
                            $modelHeader->firstname = $modelHeader->firstname;
                        }
                        $modelHeader->phone_number = $modelHeader->employee_mobile_phone_no;
                    }

                    if ($sn != '' && $eployee_exists_status == 0 && $eployee_exists_nonApplicant == 0) {
                        if ($modelHeader->validate()) {
                            $modelHeader->save();
                        }
                    } else if ($sn != '' && $eployee_exists_status == 1) {
                        $modelHeader->updateBeneficiary($checkIsmoney, $employeeExistsId);
                    } else if ($sn != '' && $eployee_exists_status == 0 && $eployee_exists_nonApplicant == 1) {
                        $modelHeader->updateBeneficiaryNonApplicant($checkIsmoney, $results_nonApplicantFound, $f4indexno, $firstname, $phone_number, $NID);
                    }
                    //end check for beneficiary existance
                    //update contact and current name of applicant
                    if ($applicantId >= 1) {
                        $employeeID = $modelHeader->getEmployeeUserId($applicantId);
                        $user_id = $employeeID->user_id;
                        $phoneNumber = $modelHeader->employee_mobile_phone_no;
                        $modelHeader->updateUserPhone($phoneNumber, $user_id);
                        //$modelHeader->getindexNoApplicant($applcantF4IndexNo);
                        $current_name = $modelHeader->employee_current_nameifchanged;
                        $applicant_id = $applicantId;
                        $NIN = $modelHeader->employee_NIN;
                        if ($NIN != '') {
                            $modelHeader->updateEmployeeNane($current_name, $applicant_id, $NIN);
                        }
                    }
                    //end update applicant's contact and current name
                }
                unlink('uploads/' . $date_time . $inputFiles1);
                $sms = '<p>Information Successful Uploaded.</p>';

                //Yii::$app->session->setFlash('sms', $sms);
                Yii::$app->getSession()->setFlash('success', $sms);
            } else {
                //$sms = '<p style="color: #cc0000">Operation failed, Please check excel colums.</p>';
                unlink('uploads/' . $date_time . $inputFiles1);
                $sms = '<p>Operation failed, Please check excel colums.</p>';
                Yii::$app->session->setFlash('error', $sms);
            }
        }

        return $this->render("upload_general", ['model' => $modelHeader]);
    }

    public function actionUpdate($id) {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 2) {
            $this->layout = "main_private";
        }

        $model = $this->findModel($id);
        //$model->scenario = 'update_employee';
        $model->scenario = 'Uploding_beneficiaries';
        //$model->f4indexno='';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //validate for error recording
            $model->upload_status = 1;
            $model->upload_error = '';
            //end validation check
            //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
            if ($model->applicant_id == '') {
				$splitF4Indexno=explode('.',$model->f4indexno);
				$f4indexnoSprit1=$splitF4Indexno[0];
				$f4indexnoSprit2=$splitF4Indexno[1];
				$f4indexnoSprit3=$splitF4Indexno[2];
				$regNo=$f4indexnoSprit1.".".$f4indexnoSprit2;
				$f4CompletionYear=$f4indexnoSprit3;
                $employeeID = $model->getApplicantDetails($regNo,$f4CompletionYear, $model->NID);
                $model->applicant_id = $employeeID->applicant_id;
                //end check using unique identifiers
                //check using non-unique identifiers
                if (!is_numeric($model->applicant_id) && $model->applicant_id < 1 && $model->applicant_id == '') {
                    $resultsUsingNonUniqueIdent = $model->getApplicantDetailsUsingNonUniqueIdentifiers($model->firstname, $model->middlename, $model->surname, $model->date_of_birth, $model->place_of_birth, $model->learning_institution_id, $model->programme_level_of_study, $model->programme, $model->programme_entry_year, $model->programme_completion_year);
                    $model->applicant_id = $resultsUsingNonUniqueIdent->applicant_id;
                }
                // end check using unique identifiers                            
                if (!is_numeric($model->applicant_id)) {
                    $model->applicant_id = '';
                }
                //$applicantId = $model->applicant_id;
                //check if employee is on study
                if ($model->applicant_id != '') {
                    $employeeOnstudyStatus = $model->getEmployeeOnStudyStatus($model->applicant_id);
                    if ($employeeOnstudyStatus != '') {
                        $model->employee_status = 1;
                    } else {
                        $model->employee_status = 0;
                    }
                } else {
                    $model->employee_status = 0;
                }
            }
            //end check
            // check for disbursed amount to employee
            if ($model->applicant_id > 0) {
                $resultDisbursed = $model->getIndividualEmployeesPrincipalLoan($model->applicant_id);
                if ($resultDisbursed == 0) {
                    $model->verification_status = 4;
                }
            }
            //end check

            if ($model->save()) {
                $sms = "Information Updated Successful!";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['employed-beneficiary/un-verified-uploaded-employees']);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdateBeneficiary($id) {
        $this->layout = "default_main";
        $LoanSummaryModel = new LoanSummary();
        //$model2 = new LoanSummaryDetail();
        $model = $this->findModel($id);
        $model->scenario = 'update_beneficiary';
        //$model->f4indexno='';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $sms = "Information Updated Successful!";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['employed-beneficiary/beneficiaries-verified']);
        } else {
            return $this->render('updateBeneficiary', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDeactivateBeneficiary($id) {
        $this->layout = "default_main";
        $LoanSummaryModel = new LoanSummary();
        //$model2 = new LoanSummaryDetail();
        $model = $this->findModel($id);
        $model->scenario = 'deactivate_double_employed';
        //$model->f4indexno='';
        if ($model->load(Yii::$app->request->post())) {
            $datime=date("Y_m_d_H_i_s");
            $model->support_document = UploadedFile::getInstance($model, 'support_document');
            //$model->support_document->saveAs('../../beneficiary_document/employment_status_support_document_'.$model->employed_beneficiary_id.'_'.$datime.'.'.$model->support_document->extension);
            //$model->support_document = 'beneficiary_document/employment_status_support_document_'.$model->employed_beneficiary_id.'_'.$datime.'.'.$model->support_document->extension;
			$model->support_document->saveAs(Yii::$app->params['beneficiaryDocument'].'employment_status_support_document_'.$model->employed_beneficiary_id.'_'.$datime.'.'. $model->support_document->extension);
            $model->support_document = Yii::$app->params['beneficiaryDocument'].'employment_status_support_document_'.$model->employed_beneficiary_id.'_'.$datime.'.'.$model->support_document->extension;
			
            $model->employment_end_date=date("Y-m-d");
            $model->verification_status=5;
            $model->employment_status=$model->employmentStatus2;            
            if ($model->save()) {
                if ($model->applicant_id != '') {
                    //disable and generate new loan summary
                    if ($model->employmentStatus2 != 'ONPOST' AND $model->loan_summary_id != '') {
                        $LoanSummaryID = $model->loan_summary_id;
                        $employerID = $model->employer_id;
                        \common\models\LoanBeneficiary::getNewLoanSummaryAfterDeceasedBeneficiary($LoanSummaryID, $employerID);			
                    }
                    //end
                    $sms = "Information Updated Successful!";
                    Yii::$app->getSession()->setFlash('success', $sms);
                } else {
                    $sms = "Operation failed, form IV index number is invalid";
                    Yii::$app->getSession()->setFlash('error', $sms);
                }
                return $this->redirect(['employed-beneficiary/beneficiaries-verified']);
            }
        } else {
            return $this->render('deactivateBeneficiary', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdateBeneficiaryDisabled($id) {
        $this->layout = "default_main";
        $LoanSummaryModel = new LoanSummary();
        //$model2 = new LoanSummaryDetail();
        $model = $this->findModel($id);
        $model->scenario = 'update_beneficiary';
        //$model->f4indexno='';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->employment_status == "ONPOST") {
                $model->verification_status = 0;
                $model->loan_summary_id = '';
            }
            if ($model->save()) {
                $sms = "Information Updated Successful!";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['employed-beneficiary/inative-beneficiaries']);
            }
        } else {
            return $this->render('updateBeneficiaryDisabled', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDownload() {
        $path = Yii::getAlias('@webroot') . '/dwload';
        $file = Yii::$app->params['employeeExcelTemplate'] . '/EMPLOYEES_DETAILS_TEMPLATE.xlsx';
        if (file_exists($file)) {
            return Yii::$app->response->sendFile($file);
        } else {
            throw new \yii\web\NotFoundHttpException("{$file} is not found!");
        }
    }

    /**
     * Deletes an existing EmployedBeneficiary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionList_beneficiaries($id) {
        echo "TELE";
        exit;
        $count_beneficiaries = EmployedBeneficiary::find()->where(['employer_id' => $id])->count();
        $beneficiaries = EmployedBeneficiary::find()->where(['employer_id' => $id])->orderBy('employed_beneficiary_id DESC')->all();
        if ($count_beneficiaries > 0) {
            foreach ($beneficiaries as $results)
                echo "<option value='" . $results->employed_beneficiary_id . "'>" . $results->employee_id . "</option>";
        } else {
            echo "<option>--</option>";
        }
    }

    /**
     * Finds the EmployedBeneficiary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployedBeneficiary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = EmployedBeneficiary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBeneficiariesVerified() {
        $this->layout = "default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $dataProvider = $searchModel->getVerifiedEmployeesUnderEmployer(Yii::$app->request->queryParams, $employerID);

        return $this->render('beneficiariesVerified', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionInativeBeneficiaries() {
        $this->layout = "default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $dataProvider = $searchModel->getDisabledEmployedBeneficiary(Yii::$app->request->queryParams, $employerID);

        return $this->render('inativeBeneficiaries', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionConfirmBeneficiariesEmployer() {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 2) {
            $this->layout = "main_private";
        }

        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $employedBeneficiary = new EmployedBeneficiary();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        //$action=Yii::$app->request->post('action');
        $selection = (array) Yii::$app->request->post('selection'); //typecasting
        foreach ($selection as $employed_beneficiary_id) {
            $employedBeneficiary->confirmBeneficiaryByEmployer($employerID, $employed_beneficiary_id);
        }
        if ($employed_beneficiary_id != '') {
            $sms = "Beneficiaries verified!";
            Yii::$app->getSession()->setFlash('success', $sms);
        }
        if ($employed_beneficiary_id == '') {
            $sms = " Error: No any beneficiary selected!";
            Yii::$app->getSession()->setFlash('error', $sms);
        }
        return $this->redirect(['unconfirmed-beneficiaries-list']);
    }

    public function actionIndexTreasury() {
        $this->layout = "main_private_treasury";
        $searchModel = new \backend\modules\repayment\models\EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $dataProvider = $searchModel->getGovernmentEmployees(Yii::$app->request->queryParams);

        return $this->render('indexTreasury', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionPrintloanStatement($id) {
        // get your HTML raw content without any layouts or scripts
        $htmlContent = $this->renderPartial('viewLoanStatement', ['applicant_id' => $id]);

        // setup kartik\mpdf\Pdf component
        $pdf = Yii::$app->pdf;
        $pdf->content = $htmlContent;
        return $pdf->render();

        // return the pdf output as per the destination setting
        //return $pdf->render(); 
    }

    public function actionIndexUploadEmployees() {
        $model = new EmployedBeneficiary();
        $employerModel = new EmployerSearch();
        $model->scenario = 'upload_employees';
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;	
        $employerSalarySource=$employer2->salary_source;		
        if ($model->load(Yii::$app->request->post())) {
            $datime = date("Y_m_d_H_i_s");
            $model->employeesFile = UploadedFile::getInstance($model, 'employeesFile');
            //$model->employeesFile->saveAs('uploads/' . $datime . $model->employeesFile);
            //$model->employeesFile = 'uploads/' . $datime . $model->employeesFile;
			$model->employeesFile->saveAs(Yii::$app->params['employerUploadExcelTemplate'] . $datime . $model->employeesFile);
            $model->employeesFile = Yii::$app->params['employerUploadExcelTemplate'] . $datime . $model->employeesFile;
			$uploadedFileName=$model->employeesFile;
			$traced_by=$model->traced_by;
            $data = \moonland\phpexcel\Excel::widget([
                        'mode' => 'import',
                        'fileName' => $model->employeesFile,
                        'setFirstRecordAsKeys' => true,
                        'setIndexSheetByName' => true,
            ]);
            foreach ($data as $rows) {
                $model = new EmployedBeneficiary();
				$generalMatch='';
                $model->scenario = 'upload_employees2';
                $model->employer_id = $employerID;
				$model->salary_source=$salary_source;
                $model->created_by = \Yii::$app->user->identity->user_id;
                $model->employment_status = "ONPOST";
                $model->created_at = date("Y-m-d H:i:s");
                $model->employee_id = EmployedBeneficiary::formatRowData($rows['EMPLOYEE_ID']);
                $f4indexno = $applcantF4IndexNo = $model->f4indexno = EmployedBeneficiary::formatRowData($rows['FORM_FOUR_INDEX_NUMBER']);
                $model->firstname = EmployedBeneficiary::formatRowData($rows['FIRST_NAME']);
                $model->middlename = EmployedBeneficiary::formatRowData($rows['MIDDLE_NAME']);
                $model->surname = EmployedBeneficiary::formatRowData($rows['SURNAME']);
				$model->LOAN_BENEFICIARY_STATUS = $model->formatRowData($rows['LOAN_BENEFICIARY_STATUS']);
				$model->form_four_completion_year = $model->formatRowData($rows['FORM_FOUR_COMPLETION_YEAR']);
                $model->date_of_birth = '';
                $wardName = '';
                $phone_number = $model->phone_number = EmployedBeneficiary::formatRowData($rows['MOBILE_PHONE_NUMBER']);
                $model->current_name = '';
                $institution_code = EmployedBeneficiary::formatRowData($rows['INSTITUTION_OF_STUDY']);
                $model->learning_institution_id = $model->getLearningInstitutionID($institution_code);
                $NIN = $model->NID = EmployedBeneficiary::formatRowData($rows['NATIONAL_IDENTIFICATION_NUMBER']);
                $checkIsmoney = $model->basic_salary = '';
                $model->sex = EmployedBeneficiary::formatRowData($rows['GENDER(MALE_OR_FEMALE)']);
                $entryYear = $model->programme_entry_year = EmployedBeneficiary::formatRowData($rows['ENTRY_YEAR']);
                $completionYear = $model->programme_completion_year = EmployedBeneficiary::formatRowData($rows['COMPLETION_YEAR']);
                $programme1 = EmployedBeneficiary::formatRowData($rows['PROGRAMME_STUDIED']);
				$salary_source = EmployedBeneficiary::formatRowData($rows['SALARY_SOURCE']);
                $programme_level_of_study1 = EmployedBeneficiary::formatRowData($rows['STUDY_LEVEL']);
                $programme_level_of_study = \backend\modules\application\models\ApplicantCategory::findOne(['applicant_category' => $programme_level_of_study1]);
                $studyLevel = $model->programme_level_of_study = $programme_level_of_study->applicant_category_id;
                $programmeID = \backend\modules\application\models\Programme::findOne(['programme_name' => $programme1]);
                $programmeStudied = $model->programme = $programmeID->programme_id;
                $model->uploaded_learning_institution_code = $institution_code;
                $model->uploaded_level_of_study = $programme_level_of_study1;
                $model->uploaded_programme_studied = $programme1;
                $model->uploaded_place_of_birth = $wardName;
                $model->uploaded_sex = $model->sex;
                $model->verification_status = 0;
				$model->traced_by=$traced_by;
				$f4CompletionYear = $model->form_four_completion_year;
			    $regNo=$model->f4indexno;
			    $updated_at=date("Y-m-d H:i:s");
				$updated_by=$loggedin;

				if($salary_source=='central government'){
					//check employer salary source
					if($employerSalarySource==1 OR $employerSalarySource==3){
						$model->salary_source=1;
					}else{
						$model->salary_source='';
					}
					//end check
							
				}else if($salary_source=='own source'){
					//check employer salary source
					if($employerSalarySource !=1){
						$model->salary_source=2;
					}else{
						$model->salary_source='';
					}
					//end check					
				}else if($salary_source=='both'){
					//check employer salary source
					if($employerSalarySource==3){
						$model->salary_source=3;
					}else{
						$model->salary_source='';
					}
					//end check					
				}else{
					$model->salary_source='';
				}
                $EntryAcademicYear = $model->getEntryYear($entryYear);
                $completionYear2 = substr($completionYear, 2, 4);
                $CompletionAcademicYear = $model->getCompletionYear($completionYear2);

                //echo $EntryAcademicYear."<br/>".$CompletionAcademicYear;
                //exit;
                if ($model->sex == 'MALE') {
                    $model->sex = 'M';
                } else if ($model->sex == 'FEMALE') {
                    $model->sex = 'F';
                } else {
                    $model->sex = '';
                }
                //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
				/*
				$splitF4Indexno=explode('.',$applcantF4IndexNo);
				$f4indexnoSprit1=$splitF4Indexno[0];
				$f4indexnoSprit2=$splitF4Indexno[1];
				$f4indexnoSprit3=$splitF4Indexno[2];
				$regNo=$f4indexnoSprit1.".".$f4indexnoSprit2;
				$f4CompletionYear=$f4indexnoSprit3;
				*/
				$firstname = $model->firstname;
                $middlename = $model->middlename;
                $surname = $model->surname;				
				$academicInstitution = $model->learning_institution_id;
				
				$resultsCountExistIndexNo=$model->getAllApplicantsCount($regNo,$f4CompletionYear);
				if($resultsCountExistIndexNo == 1){
            $employeeID = $model->getApplicantDetails($regNo,$f4CompletionYear, $NIN);
            $model->applicant_id = $employeeID->applicant_id;
				}else if($resultsCountExistIndexNo > 1){
			$resultsUsingNonUniqueIdent = $model->getApplicantDetailsNonUniqIdentifierF4indexno($regNo,$f4CompletionYear,$firstname, $middlename, $surname, $academicInstitution, $studyLevel, $programmeStudied, $EntryAcademicYear, $CompletionAcademicYear);
               $model->applicant_id = $resultsUsingNonUniqueIdent->applicant_id;		
				}else if($resultsCountExistIndexNo==0){
			$model->applicant_id='';		
				}
				$match="f4indexno repeated=>".$resultsCountExistIndexNo.", ";
				$generalMatch.=$match;
				
				
                //$employeeID = $model->getApplicantDetails($regNo,$f4CompletionYear,$NIN);
                //$model->applicant_id = $employeeID->applicant_id;
                //end check using unique identifiers
                //check using non-unique identifiers
                if (!is_numeric($model->applicant_id) && $model->applicant_id < 1 && $model->applicant_id == '') {
					$match="f4indexno Mis-match, ";
				    $generalMatch.=$match;				
                    
                    $resultsUsingNonUniqueIdent = $model->getApplicantDetailsUsingNonUniqueIdentifiers($firstname, $middlename, $surname, $academicInstitution, $studyLevel, $programmeStudied, $EntryAcademicYear, $CompletionAcademicYear);
                    $model->applicant_id = $resultsUsingNonUniqueIdent->applicant_id;
				
					if($model->applicant_id==''){
					$match="Other Criteria Mis-match, ";
					$generalMatch.=	$match;				
					}else if($model->applicant_id > 0){
					$match="Other Criteria match, ";
					$generalMatch.=	$match;				
					}
					
                }else{
					$match="f4indexno match, ";
					$generalMatch.=	$match;		
			}
                // end check using unique identifiers                            
                if (!is_numeric($model->applicant_id)) {
                    $model->applicant_id = '';
                }
                $applicantId = $model->applicant_id;
                //check if employee is on study
                if ($model->applicant_id != '') {
                    $employeeOnstudyStatus = $model->getEmployeeOnStudyStatus($model->applicant_id);
                    if ($employeeOnstudyStatus != '') {
                        $model->employee_status = 1;
                    } else {
                        $model->employee_status = 0;
                    }
                } else {
                    $model->employee_status = 0;
                }
                //end check 
                // check if beneficiary exists in beneficiary table and save
                $employeeExist = $model->checkEmployeeExists($applicantId, $model->employer_id, $model->employee_id);
                if ($employeeExist == 1) {
                    $eployee_exists_status = 1;
                    $employeeExistsID = $model->getEmployeeExists($applicantId, $model->employer_id, $model->employee_id);
                    $employeeExistsId = $employeeExistsID->employed_beneficiary_id;
					if($employeeExistsID->verification_status==1){
					$model->verification_status = $employeeExistsID->verification_status;
					}
                } else {
                    $eployee_exists_status = 0;
                    //check if nonApplicant exists in beneficiary table
                    $nonApplicantFound = $model->checkEmployeeExistsNonApplicant($f4indexno, $model->employer_id, $model->employee_id,$f4CompletionYear);
                    if ($nonApplicantFound == 1) {
                        $eployee_exists_nonApplicant = 1;
                        $resultdNonApplicantExistID = $model->getEmployeeExistsNonApplicantID($f4indexno, $model->employer_id, $model->employee_id,$f4completionyear);
                        $results_nonApplicantFound = $resultdNonApplicantExistID->employed_beneficiary_id;
						if($resultdNonApplicantExistID->verification_status==1){
						$model->verification_status = $resultdNonApplicantExistID->verification_status;
						}
                    } else {
                        $eployee_exists_nonApplicant = 0;
                    }
                    //end check if nonApplicant Exists 
                }
                //validate for error recording
                $model->validate();

                $reason = '';
                if ($model->hasErrors()) {
                    $errors = $model->errors;
                    foreach ($errors as $key => $value) {
                        $reason = $reason . $value[0] . ',  ';
                    }
                }
                if ($reason != '') {
                    $model->upload_status = 0;
                    $model->upload_error = $reason;
                } else {
                    $model->upload_status = 1;
                    $model->upload_error = '';
                }
                //end validation check
                // check for disbursed amount to employee
                if ($model->applicant_id > 0) {
                    $resultDisbursed = $model->getIndividualEmployeesPrincipalLoan($model->applicant_id);
                    if ($resultDisbursed == 0) {
                        $model->verification_status = 4;
                    }
                }
                //end check
				//check names and education history match
			   if($model->applicant_id >0){
				$applicantNameMatchCount=$model->getCheckApplicantNamesMatch($model->applicant_id,$firstname, $middlename, $surname);
				if($applicantNameMatchCount > 0){
				$match="Employee Names match, ";
                $generalMatch.=	$match;				
				}else{
				$match="Employee Names Mis-match, ";
                $generalMatch.=	$match;				
				}
			   }
				//end check names and education history match
                $model->matching=$generalMatch;
                if ($eployee_exists_status == 0 && $eployee_exists_nonApplicant == 0) {
                    if ($model->employee_id != 'T12XX35') {
                        $model->save(false);
                    }
                } else if ($eployee_exists_status == 1) {
                    //$model->updateBeneficiary($checkIsmoney,$employeeExistsId);
                    $model->updateEmployeeReuploaded($model->employer_id, $model->employee_id, $model->applicant_id, $model->basic_salary, $model->employment_status, $model->NID, $model->f4indexno,$f4completionyear, $model->firstname, $model->middlename, $model->surname, $model->sex, $model->learning_institution_id, $model->phone_number, $model->upload_status, $model->upload_error, $model->programme_entry_year, $model->programme_completion_year, $model->programme, $model->programme_level_of_study, $model->employee_status, $model->current_name, $model->uploaded_learning_institution_code, $model->uploaded_level_of_study, $model->uploaded_programme_studied, $model->uploaded_place_of_birth, $model->uploaded_sex, $model->verification_status, $employeeExistsId,$model->salary_source,$model->LOAN_BENEFICIARY_STATUS,$model->matching,$model->traced_by,$updated_at,$updated_by);
                } else if ($eployee_exists_status == 0 && $eployee_exists_nonApplicant == 1) {
                    //$model->updateBeneficiaryNonApplicant($checkIsmoney,$results_nonApplicantFound,$f4indexno,$firstname,$phone_number,$NIN); 

                    $model->updateEmployeeReuploaded($model->employer_id, $model->employee_id, $model->applicant_id, $model->basic_salary, $model->employment_status, $model->NID, $model->f4indexno,$f4completionyear, $model->firstname, $model->middlename, $model->surname, $model->sex, $model->learning_institution_id, $model->phone_number, $model->upload_status, $model->upload_error, $model->programme_entry_year, $model->programme_completion_year, $model->programme, $model->programme_level_of_study, $model->employee_status, $model->current_name, $model->uploaded_learning_institution_code, $model->uploaded_level_of_study, $model->uploaded_programme_studied, $model->uploaded_place_of_birth, $model->uploaded_sex, $model->verification_status, $results_nonApplicantFound,$model->salary_source,$model->LOAN_BENEFICIARY_STATUS,$model->matching,$model->traced_by,$updated_at,$updated_by);
                }

                $doneUpload = 1;
            }
			unlink($uploadedFileName);
            if ($doneUpload == 1) {
                unlink($model->employeesFile);
                $sms = "<p>Information uploaded successful</p>";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['index-upload-employees']);
            } else {
                $sms = "<p>Operation failed, no record saved!</p>";
                Yii::$app->getSession()->setFlash('danger', $sms);
                return $this->redirect(['index-upload-employees']);
            }
        } else {
            return $this->render('index', [
                        'model' => $model
            ]);
        }
    }

    public function actionIndexViewBeneficiary() {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 1) {
            $this->layout = "main_private_beneficiary";
        }

        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;

        //check government employers if had stated salary source
        $employerSalarySource = Employer::getEmployerSalarySource($employerID);
        //end check

        $dataProvider = $searchModel->getVerifiedEmployeesUnderEmployer(Yii::$app->request->queryParams, $employerID);
        $dataProviderNonBeneficiary = $searchModel->getNonVerifiedEmployees(Yii::$app->request->queryParams, $employerID);

        if (isset($_POST['EmployedBeneficiary'])) {
            //CHECKING IF A USER STILL IS HAVING ACTIVE SESSION...
            if (\Yii::$app->user->identity->user_id == '' OR \Yii::$app->user->identity->user_id == 0) {
                unlink('uploads/' . $date_time . $inputFiles1);
                $sms = '<p>Operation did not complete,session expired </p>';
                Yii::$app->getSession()->setFlash('error', $sms);
                return $this->redirect(['upload-error']);
            } else {
                $modelHeader = new EmployedBeneficiary();
                $modelHeader->scenario = 'upload_employees';
                $employerModel = new EmployerSearch();
                $modelHeader->created_by = \Yii::$app->user->identity->user_id;
                $loggedin = $modelHeader->created_by;
                $employer2 = $employerModel->getEmployer($loggedin);
                $employerID = $employer2->employer_id;
            }
            if ($modelHeader->load(Yii::$app->request->post())) {
                $date_time = date("Y_m_d_H_i_s");
                $inputFiles1 = UploadedFile::getInstance($modelHeader, 'employeesFile');
                $modelHeader->employeesFile = UploadedFile::getInstance($modelHeader, 'employeesFile');
                $modelHeader->upload($date_time);
                $inputFiles = 'uploads/' . $date_time . $inputFiles1;

                try {
                    $inputFileType = \PHPExcel_IOFactory::identify($inputFiles);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFiles);
                } catch (Exception $ex) {
                    die('Error');
                }

                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                if (strcmp($highestColumn, "N") == 0 && $highestRow >= 4) {
                    //VALIDATING IF A FILE HAS NO RECORD TO BE DISCARDED...
                    $row = 4;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    $sn = $rowData[0][0];
                    if ($sn == '') {
                        unlink('uploads/' . $date_time . $inputFiles1);
                        $sms = '<p>Operation failed, file with no records is not allowed</p>';
                        Yii::$app->getSession()->setFlash('error', $sms);
                        return $this->redirect(['upload-error']);
                    } else {
                        $objPHPExcelOutput = new \PHPExcel();
                        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
                        $objPHPExcelOutput->setActiveSheetIndex(0);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'EMPLOYEES UPLOAD REPORT');
                        $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:O1', 'EMPLOYEES UPLOAD REPORT');

                        $rowCount = 2;
                        $s_no = 0;
                        $customTitle = ['SNo', 'EMPLOYEE_ID', 'FORM FOUR INDEX NUMBER', 'FIRST NAME', 'MIDDLE NAME', 'SURNAME', 'DATE OF BIRTH(Year-Month-Day)', 'PLACE OF BIRTH(WARD)', 'MOBILE PHONE NUMBER', 'CURRENT NAME IF CHANGED', 'NAME OF INSTITUTION OF STUDY', 'NATIONAL IDENTIFICATION NUMBER(NIN)', 'GROSS SALARY(TZS)', 'GENDER', 'UPLOAD STATUS', 'FAILED REASON'];
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $customTitle[7]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $customTitle[8]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $customTitle[9]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, $customTitle[10]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('L' . $rowCount, $customTitle[11]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('M' . $rowCount, $customTitle[12]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('N' . $rowCount, $customTitle[13]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, $customTitle[14]);
                        $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, $customTitle[15]);

                        for ($row = 4; $row <= $highestRow; ++$row) {
                            $s_no++;
                            $rowCount++;
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                            $modelHeader = new EmployedBeneficiary();
                            $modelHeader->scenario = 'Uploding_beneficiaries';
                            $modelHeader->employer_id = $employerID;
                            $modelHeader->created_by = \Yii::$app->user->identity->user_id;
                            $modelHeader->employment_status = "ONPOST";
                            $modelHeader->created_at = date("Y-m-d H:i:s");
                            $modelHeader->employee_check_number = EmployedBeneficiary::formatRowData($rowData[0][1]);
                            $modelHeader->employee_f4indexno = EmployedBeneficiary::formatRowData($rowData[0][2]);
                            $modelHeader->employee_FIRST_NAME = EmployedBeneficiary::formatRowData($rowData[0][3]);
                            $modelHeader->employee_MIDDLE_NAME = EmployedBeneficiary::formatRowData($rowData[0][4]);
                            $modelHeader->employee_SURNAME = EmployedBeneficiary::formatRowData($rowData[0][5]);
                            $modelHeader->employee_DATE_OF_BIRTH = EmployedBeneficiary::formatRowData($rowData[0][6]);
                            $modelHeader->employee_PLACE_OF_BIRTH = EmployedBeneficiary::formatRowData($rowData[0][7]);
                            $modelHeader->employee_mobile_phone_no = EmployedBeneficiary::formatRowData($rowData[0][8]);
                            $modelHeader->employee_current_nameifchanged = EmployedBeneficiary::formatRowData($rowData[0][9]);
                            $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY = EmployedBeneficiary::formatRowData($rowData[0][10]);
                            $modelHeader->employee_NIN = EmployedBeneficiary::formatRowData($rowData[0][11]);
                            $modelHeader->basic_salary = EmployedBeneficiary::formatRowData($rowData[0][12]);
                            $modelHeader->sex = EmployedBeneficiary::formatRowData($rowData[0][13]);
                            if ($modelHeader->sex == 'MALE') {
                                $modelHeader->sex = 'M';
                            } else if ($modelHeader->sex == 'FEMALE') {
                                $modelHeader->sex = 'F';
                            }
                            // added 13-02-2018 
                            $modelHeader->f4indexno = $modelHeader->employee_f4indexno;
                            $modelHeader->firstname = $modelHeader->employee_FIRST_NAME;
                            $modelHeader->middlename = $modelHeader->employee_MIDDLE_NAME;
                            $modelHeader->surname = $modelHeader->employee_SURNAME;
                            $modelHeader->date_of_birth = $modelHeader->employee_DATE_OF_BIRTH;
                            $wardName = $modelHeader->employee_PLACE_OF_BIRTH;
                            $modelHeader->place_of_birth = $modelHeader->getWardID($wardName);
                            $modelHeader->phone_number = $modelHeader->employee_mobile_phone_no;
                            $institution_code = $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY;
                            $modelHeader->learning_institution_id = $modelHeader->getLearningInstitutionID($institution_code);
                            $modelHeader->NID = $modelHeader->employee_NIN;

                            $modelHeader->firstname = trim($modelHeader->employee_FIRST_NAME);
                            $checkIsmoney = $modelHeader->basic_salary;
                            $applcantF4IndexNo = $modelHeader->employee_f4indexno;
                            $NIN = $modelHeader->employee_NIN;
                            //check applicant if exists using unique identifiers i.e employee_f4indexno and employee_NIN
                            $employeeID = $modelHeader->getApplicantDetails($applcantF4IndexNo, $NIN);
                            $modelHeader->applicant_id = $employeeID->applicant_id;
                            //end check using unique identifiers
                            //check using non-unique identifiers
                            if (!is_numeric($modelHeader->applicant_id)) {
                                $firstname = $modelHeader->employee_FIRST_NAME;
                                $middlename = $modelHeader->employee_MIDDLE_NAME;
                                $surname = $modelHeader->employee_SURNAME;
                                $dateofbirth = $modelHeader->employee_DATE_OF_BIRTH;
                                $placeofbirth = $modelHeader->employee_PLACE_OF_BIRTH;
                                $academicInstitution = $modelHeader->employee_NAME_OF_INSTITUTION_OF_STUDY;
                                $resultsUsingNonUniqueIdent = $modelHeader->getApplicantDetailsUsingNonUniqueIdentifiers($firstname, $middlename, $surname, $dateofbirth, $placeofbirth, $academicInstitution);
                                $modelHeader->applicant_id = $resultsUsingNonUniqueIdent->applicant_id;
                            }
                            // end check using unique identifiers

                            $modelHeader->employee_id = $modelHeader->employee_check_number;
                            if (!is_numeric($modelHeader->applicant_id)) {
                                $modelHeader->applicant_id = '';
                            }
                            if (!is_numeric($modelHeader->created_by)) {
                                $modelHeader->created_by = 0;
                            }
                            $applicantId = $modelHeader->applicant_id;
                            $employerId = $modelHeader->employer_id;
                            $employeeId = $modelHeader->employee_id;
                            $f4indexno = $modelHeader->employee_f4indexno;
                            $nameChanged = trim($modelHeader->employee_current_nameifchanged);
                            if ($nameChanged == '' OR empty($nameChanged)) {
                                $firstname = $modelHeader->firstname;
                            } else {
                                $firstname = $modelHeader->employee_current_nameifchanged;
                            }
                            $phone_number = $modelHeader->employee_mobile_phone_no;
                            $NID = $modelHeader->employee_NIN;

                            $modelHeader->validate();
                            $reason = '';
                            if ($modelHeader->hasErrors()) {
                                $errors = $modelHeader->errors;
                                foreach ($errors as $key => $value) {
                                    $reason = $reason . $value[0] . '  ';
                                }
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelHeader->employee_id);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelHeader->f4indexno);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelHeader->firstname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelHeader->middlename);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $modelHeader->surname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $modelHeader->date_of_birth);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $wardName);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $modelHeader->phone_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $modelHeader->employee_current_nameifchanged);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, $institution_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('L' . $rowCount, $NID);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('M' . $rowCount, $modelHeader->basic_salary);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('N' . $rowCount, $modelHeader->sex);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, 'UPLOADED FAILED');
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, $reason);
                            } else {
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $s_no);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $modelHeader->employee_id);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $modelHeader->f4indexno);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $modelHeader->firstname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $modelHeader->middlename);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $modelHeader->surname);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $modelHeader->date_of_birth);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $wardName);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $modelHeader->phone_number);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $modelHeader->employee_current_nameifchanged);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, $institution_code);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('L' . $rowCount, $NID);
                                $objPHPExcelOutput->getActiveSheet()->SetCellValue('M' . $rowCount, $modelHeader->basic_salary);

                                // check if beneficiary exists in beneficiary table and save
                                $employeeExist = $modelHeader->checkEmployeeExists($applicantId, $employerId, $employeeId);
                                $employeeExistsId = $employeeExist->employed_beneficiary_id;
                                if ($employeeExistsId >= 1) {
                                    $eployee_exists_status = 1;
                                } else {
                                    $eployee_exists_status = 0;
                                    //check if nonApplicant exists in beneficiary table
                                    $nonApplicantFound = $modelHeader->checkEmployeeExistsNonApplicant($f4indexno, $employerId, $employeeId);
                                    $results_nonApplicantFound = $nonApplicantFound->employed_beneficiary_id;
                                    if ($results_nonApplicantFound >= 1) {
                                        $eployee_exists_nonApplicant = 1;
                                    } else {
                                        $eployee_exists_nonApplicant = 0;
                                    }
                                    //end check if nonApplicant Exists 
                                }

                                if ($sn != '' && $eployee_exists_status == 0 && $eployee_exists_nonApplicant == 0) {
                                    $modelHeader->save();
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, 'UPLOADED SUCCESSFUL');
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, 'N/A');
                                } else if ($sn != '' && $eployee_exists_status == 1) {
                                    $modelHeader->updateBeneficiary($checkIsmoney, $employeeExistsId);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, 'UPLOAD FAILED');
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, 'EMPLOYEE EXISTS');
                                } else if ($sn != '' && $eployee_exists_status == 0 && $eployee_exists_nonApplicant == 1) {
                                    $modelHeader->updateBeneficiaryNonApplicant($checkIsmoney, $results_nonApplicantFound, $f4indexno, $firstname, $phone_number, $NID);
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, 'UPLOAD FAILED');
                                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, 'APPLICANT EXISTS');
                                }
                            }
                        }
                        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:P' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
                        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="Employees Upload Report.xls"');
                        header('Cache-Control: max-age=0');
                        $writer->save('php://output');
                    }
                } else {
                    unlink('uploads/' . $date_time . $inputFiles1);
                    $sms = '<p>Operation failed, file with no records is not allowed</p>';
                    Yii::$app->getSession()->setFlash('error', $sms);
                    return $this->redirect(['upload-error']);
                }
            }
        }
        return $this->render('indexUploadEmployees', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProviderNonBeneficiary' => $dataProviderNonBeneficiary, 'employerSalarySource' => $employerSalarySource, 'employerID' => $employerID,
        ]);
    }

    public function actionStudyLevel() {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 1) {
            $this->layout = "main_private_beneficiary";
        }
        $searchModelApplicantCategory = new ApplicantCategorySearch();
        $dataProvider = $searchModelApplicantCategory->search(Yii::$app->request->queryParams);

        return $this->render('studyLevel', [
                    'searchModel' => $searchModelApplicantCategory,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProgramme() {
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 1) {
            $this->layout = "main_private_beneficiary";
        }
        $programmeSearch = new ProgrammeSearch();
        $dataProvider = $programmeSearch->searchProgrameEmployer(Yii::$app->request->queryParams);

        return $this->render('programme', [
                    'searchModel' => $programmeSearch,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFailedUploadedEmployees() {
        //$this->layout="default_main";
        $user_loged_in = Yii::$app->user->identity->login_type;
        if ($user_loged_in == 5) {
            $this->layout = "main_private";
        } else if ($user_loged_in == 1) {
            $this->layout = "main_private_beneficiary";
        }
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $dataProvider = $searchModel->getFailedUploadedEmployees(Yii::$app->request->queryParams, $employerID);
        return $this->render('failedUploadedEmployees', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportFailedEmployee() {
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $uploadStatus = 0;

        $objPHPExcelOutput = new \PHPExcel();
        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
        $objPHPExcelOutput->setActiveSheetIndex(0);
        //$objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'EMPLOYEES UPLOAD REPORT');
        //$objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:S1', 'EMPLOYEES UPLOAD REPORT');

        $rowCount = 1;
        $customTitle = ['SNo', 'EMPLOYEE_ID', 'FORM_FOUR_INDEX_NUMBER', 'FIRST_NAME', 'MIDDLE_NAME', 'SURNAME', 'DATE_OF_BIRTH', 'PLACE_OF_BIRTH(WARD)', 'MOBILE_PHONE_NUMBER', 'CURRENT_NAME_IF_CHANGED', 'NAME_OF_INSTITUTION_OF_STUDY', 'ENTRY_YEAR', 'COMPLETION_YEAR', 'LEVEL_OF_STUDY', 'PROGRAMME_STUDIED', 'NATIONAL_IDENTIFICATION_NUMBER', 'GROSS_SALARY(TZS)', 'GENDER(MALE_OR_FEMALE)', 'UPLOAD ERROR'];
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $customTitle[7]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $customTitle[8]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $customTitle[9]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, $customTitle[10]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('L' . $rowCount, $customTitle[11]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('M' . $rowCount, $customTitle[12]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('N' . $rowCount, $customTitle[13]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, $customTitle[14]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, $customTitle[15]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('Q' . $rowCount, $customTitle[16]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('R' . $rowCount, $customTitle[17]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('S' . $rowCount, $customTitle[18]);
        $objPHPExcelOutput->getActiveSheet()->getStyle('A' . $rowCount . ':' . 'S' . $rowCount)->getFont()->setBold(true);
        $QUERY_BATCH_SIZE = 1000;
        $offset = 0;
        $done = false;
        $startTime = time();
        //$rowCount=0;
        $i = 0;
        $limit = 100;
        $results = EmployedBeneficiary::getEmployeesFailed($employerID, $uploadStatus, $offset, $limit);
        foreach ($results as $values) {
            $i++;
            ++$rowCount;

            //HERE START EXCEL
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $values->employee_id);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $values->f4indexno);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $values->firstname);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $values->middlename);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $values->surname);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $values->date_of_birth);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $values->uploaded_place_of_birth);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $values->phone_number);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('J' . $rowCount, $values->current_name);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('K' . $rowCount, $values->uploaded_learning_institution_code);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('L' . $rowCount, $values->programme_entry_year);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('M' . $rowCount, $values->programme_completion_year);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('N' . $rowCount, $values->uploaded_level_of_study);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('O' . $rowCount, $values->uploaded_programme_studied);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('P' . $rowCount, $values->NID);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('Q' . $rowCount, $values->basic_salary);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('R' . $rowCount, $values->uploaded_sex);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('S' . $rowCount, $values->upload_error);
        }
        $highestRow = $rowCount;
        //$highestRow=6;
        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:S' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Failed Uploaded Employees.xls"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function actionConfirmUploadedEmployee() {
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $selection1 = Yii::$app->request->post();
        $selection = (array) Yii::$app->request->post('selection'); //typecasting
        if (count($selection) > 0) {
            foreach ($selection as $employedBeneficiaryID) {
                $employed_beneficiary_id = $employedBeneficiaryID;
                $employedBeneficiary = \frontend\modules\repayment\models\EmployedBeneficiary::findOne(['employed_beneficiary_id' => $employed_beneficiary_id]);
                $employedBeneficiary->confirmed = 1;
                $employedBeneficiary->employment_start_date = date("Y-m-d");
                $applicantID = $employedBeneficiary->applicant_id;
                $resultsCheckEmployed = \frontend\modules\repayment\models\EmployedBeneficiary::checkDoubleEmployed($applicantID, $employerID);
                if ($resultsCheckEmployed == 1) {
                    $employedBeneficiary->mult_employed = 1;
                } else {
                    $employedBeneficiary->mult_employed = 0;
                }

                // here for logs
                $old_data = \yii\helpers\Json::encode($employedBeneficiary->oldAttributes);
                //end for logs
                $employedBeneficiary->save();
                // here for logs                        					
                $new_data = \yii\helpers\Json::encode($employedBeneficiary->attributes);
                $model_logs = \common\models\base\Logs::CreateLogall($employedBeneficiary->employed_beneficiary_id, $old_data, $new_data, "employed_beneficiary", "UPDATE", 1);
                //end for logs
            }
            $sms = "<p>You have successfully confirmed employee!!!</p>";
            Yii::$app->getSession()->setFlash('success', $sms);
            return $this->redirect(['un-verified-uploaded-employees']);
        } else if (count($selection) <= 0 && $selection1['employedBeneficiary']['employed_beneficiary_id'] == '' && Yii::$app->request->post()) {
            $sms = "<p>No selection done!!!</p>";
            Yii::$app->getSession()->setFlash('danger', $sms);
            return $this->redirect(['un-verified-uploaded-employees']);
        }
        return $this->redirect(['un-verified-uploaded-employees']);
    }

    public function actionConfirmEmployeebulk() {
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $employedBeneficiary = \frontend\modules\repayment\models\EmployedBeneficiary::find()
                ->where(['verification_status' =>[0,4], 'confirmed' => 0, 'employment_status' => 'ONPOST', 'upload_status' => 1, 'employer_id' => $employerID])
                ->all();
        foreach ($employedBeneficiary as $employedBeneficiaryID) {
            $employed_beneficiary_id = $employedBeneficiaryID->employed_beneficiary_id;
            $employedBeneficiary = \frontend\modules\repayment\models\EmployedBeneficiary::findOne(['employed_beneficiary_id' => $employed_beneficiary_id]);
            $employedBeneficiary->confirmed = 1;
            $employedBeneficiary->employment_start_date = date("Y-m-d");
            $applicantID = $employedBeneficiary->applicant_id;
            $resultsCheckEmployed = \frontend\modules\repayment\models\EmployedBeneficiary::checkDoubleEmployed($applicantID, $employerID);
            if ($resultsCheckEmployed == 1) {
                $employedBeneficiary->mult_employed = 1;
            } else {
                $employedBeneficiary->mult_employed = 0;
            }

            // here for logs
            $old_data = \yii\helpers\Json::encode($employedBeneficiary->oldAttributes);
            //end for logs
            $employedBeneficiary->save();
            // here for logs                        					
            $new_data = \yii\helpers\Json::encode($employedBeneficiary->attributes);
            $model_logs = \common\models\base\Logs::CreateLogall($employedBeneficiary->employed_beneficiary_id, $old_data, $new_data, "employed_beneficiary", "UPDATE", 1);
            //end for logs
        }
        $sms = "<p>You have successfully confirmed employee!!!</p>";
        Yii::$app->getSession()->setFlash('success', $sms);
        return $this->redirect(['un-verified-uploaded-employees']);
    }
	
	public function actionNonBeneficiaries()
    {
		$employerModel = new EmployerSearch();
        $searchModel = new EmployedBeneficiarySearch();
        $employedBeneficiary = new EmployedBeneficiary();
		$loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $dataProvider = $searchModel->getEmployeesUnderEmployerNonBeneficiary(Yii::$app->request->queryParams,$employerID);

        return $this->render('nonBeneficiariesConfirmed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'employerID'=>$employerID,
        ]);
    }
	/*
	public function actionUploadSalaries() {
        $this->layout="default_main";
		$employedBeneModel = new EmployedBeneficiary();
        $searchModel = new EmployedBeneficiarySearch();
		$employedBeneModel->scenario = 'update_beneficiaries_salaries';
        $employerModel = new EmployerSearch();        
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $dataProvider = $searchModel->getUnconfirmedBeneficiaries2(Yii::$app->request->queryParams, $employerID);
        $verification_status = 1;
        $results = $employedBeneModel->getUnverifiedEmployees($verification_status, $employerID);
        return $this->render('uploadBeneficiariesSalaries', [
                    'model' => $employedBeneModel,
					'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'totalUnverifiedEmployees' => $results,
        ]);
    }
	*/
	public function actionUploadSalaries() {
		$this->layout="default_main";
        $model = new EmployedBeneficiary();
        $employerModel = new EmployerSearch();
        $model->scenario = 'update_beneficiaries_salaries';
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;	
        $employerSalarySource=$employer2->salary_source;		
        if ($model->load(Yii::$app->request->post())) {
            $datime = date("Y_m_d_H_i_s");
            $model->employeesFile = UploadedFile::getInstance($model, 'employeesFile');
			$model->employeesFile->saveAs(Yii::$app->params['employerUpdateBeneficiariesSalaries'] . $datime . $model->employeesFile);
            $model->employeesFile = Yii::$app->params['employerUpdateBeneficiariesSalaries'] . $datime . $model->employeesFile;
			$uploadedFileName=$model->employeesFile;
            $data = \moonland\phpexcel\Excel::widget([
                        'mode' => 'import',
                        'fileName' => $model->employeesFile,
                        'setFirstRecordAsKeys' => true,
                        'setIndexSheetByName' => true,
            ]);			
			//prepare output for error header
					$objPHPExcelOutput = new \PHPExcel();
                    $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcelOutput->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
                    $objPHPExcelOutput->setActiveSheetIndex(0);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'UPLOADED BENEFICIARIES SALARY REPORT');
                    $objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:H1', 'UPLOADED BENEFICIARIES SALARY REPORT');					
					
					$rowCount = 2;
					$highestRow=1;
                    $s_no = 0;
                    $customTitle = ['SNo', 'EMPLOYEE_ID', 'FORM FOUR INDEX NUMBER', 'FIRST NAME', 'MIDDLE NAME', 'SURNAME','GROSS_SALARY(TZS)','UPLOAD STATUS','FAILED REASON'];
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $customTitle[7]);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $customTitle[8]);
			//end prepare output for error header
			$i=0;
            foreach ($data as $rows) {
                $model = new EmployedBeneficiary();
                $model->scenario = 'update_beneficiaries_salaries2';
                $model->employer_id = $employerID;
				$model->salary_source=$salary_source;
                $model->updated_by = \Yii::$app->user->identity->user_id;
                $model->employment_status = "ONPOST";
                $model->updated_at = date("Y-m-d H:i:s");
                $model->employee_id = EmployedBeneficiary::formatRowData($rows['EMPLOYEE_ID']);
                $f4indexno = $applcantF4IndexNo = $model->f4indexno = EmployedBeneficiary::formatRowData($rows['FORM_FOUR_INDEX_NUMBER']);
                $gross_salary = EmployedBeneficiary::formatRowData($rows['GROSS_SALARY(TZS)']);
				$model->firstname = EmployedBeneficiary::formatRowData($rows['FIRST_NAME']);
				$model->middlename = EmployedBeneficiary::formatRowData($rows['MIDDLE_NAME']);
				$model->surname = EmployedBeneficiary::formatRowData($rows['SURNAME']);
				
				$highestRow++;
				$rowCount++;
				++$i;
				//validate for error recording
                $model->validate();

                $reason = '';
                if ($model->hasErrors()) {
                    $errors = $model->errors;
                    foreach ($errors as $key => $value) {
                        $reason = $reason . $value[0] . ',  ';
                    }
                }
				
                if ($reason != '') {
                    $model->salary_upload_status = 0;
                    $model->salary_upload_fail_reasson = $reason;
					$failedStatus="Failed";
                    //prepare output for error	
                    					
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $model->employee_id);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $model->f4indexno);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $model->firstname);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $model->middlename);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $model->surname);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $gross_salary);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $failedStatus);	
                    $objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $reason);					
					//end prepare output for error
                } else {
                    $model->salary_upload_status = 1;
                    $model->salary_upload_fail_reasson = '';
					$reason="";
					$failedStatus="Successful uploaded";
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $model->employee_id);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $model->f4indexno);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $model->firstname);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $model->middlename);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $model->surname);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $gross_salary);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('H' . $rowCount, $failedStatus);
					$objPHPExcelOutput->getActiveSheet()->SetCellValue('I' . $rowCount, $reason);
                }
                //end validation check
				
				if($model->salary_upload_status==1 && $gross_salary > '0'){
                $beneficiary_details = \frontend\modules\repayment\models\EmployedBeneficiary::findOne(['employee_id' => $model->employee_id,'employer_id'=>$model->employer_id,'employment_status'=>'ONPOST']);
				$beneficiary_details->basic_salary=$gross_salary;
				$beneficiary_details->salary_upload_fail_reasson=$model->salary_upload_fail_reasson;
				$beneficiary_details->salary_upload_status=$model->salary_upload_status;
				$beneficiary_details->save();
              $doneUpload == 1; 
			}
            }
                unlink($uploadedFileName);
				if($reason != ''){
				$objPHPExcelOutput->getActiveSheet()->getStyle('A1:H' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
                $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Uploaded Beneficiaries Salary Report.xls"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
				}
                $sms = "<p>Gross Salaries updated successful</p>";
                Yii::$app->getSession()->setFlash('success', $sms);
                return $this->redirect(['beneficiaries-verified']);
            
        } else {
            return $this->render('uploadBeneficiariesSalaries', [
                        'model' => $model
            ]);
        }
    }
	
public function actionExportBeneficiaries() {
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $uploadStatus = 1;
		$verification_status=1;
		$employment_status="ONPOST";

        $objPHPExcelOutput = new \PHPExcel();
        $objPHPExcelOutput->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
        $objPHPExcelOutput->setActiveSheetIndex(0);
        //$objPHPExcelOutput->getActiveSheet()->SetCellValue('A1', 'EMPLOYEES UPLOAD REPORT');
        //$objPHPExcelOutput->setActiveSheetIndex(0)->mergeCells('A1:S1', 'EMPLOYEES UPLOAD REPORT');

        $rowCount = 1;
        $customTitle = ['SNo', 'EMPLOYEE_ID', 'FORM_FOUR_INDEX_NUMBER', 'FIRST_NAME', 'MIDDLE_NAME', 'SURNAME', 'GROSS_SALARY(TZS)'];
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $customTitle[0]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $customTitle[1]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $customTitle[2]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $customTitle[3]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $customTitle[4]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $customTitle[5]);
        $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $customTitle[6]);
        $objPHPExcelOutput->getActiveSheet()->getStyle('A' . $rowCount . ':' . 'G' . $rowCount)->getFont()->setBold(true);
        $QUERY_BATCH_SIZE = 1000;
        $offset = 0;
        $done = false;
        $startTime = time();
        //$rowCount=0;
        $i = 0;
        $limit = 100;
        $results = EmployedBeneficiary::getBeneficiariesSalary($employerID,$uploadStatus,$verification_status,$employment_status,$offset,$limit);
        foreach ($results as $values) {
            $i++;
            ++$rowCount;

            //HERE START EXCEL
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('B' . $rowCount, $values->employee_id);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('C' . $rowCount, $values->f4indexno);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('D' . $rowCount, $values->firstname);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('E' . $rowCount, $values->middlename);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('F' . $rowCount, $values->surname);
            $objPHPExcelOutput->getActiveSheet()->SetCellValue('G' . $rowCount, $values->basic_salary);
        }
        $highestRow = $rowCount;
        //$highestRow=6;
        $objPHPExcelOutput->getActiveSheet()->getStyle('A1:G' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcelOutput, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Beneficiaries Gross Salaries.xls"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
	public function actionBeneficiariesPayschedule() {
        $this->layout = "default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $dataProvider = $searchModel->getEmployedBeneficiaryRepaySchedule(Yii::$app->request->queryParams, $employerID);

        return $this->render('beneficiarypayschedule', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }
	public function actionNewrepaymentSchedule() {
        $this->layout = "default_main";
        $searchModel = new EmployedBeneficiarySearch();
        $employerModel = new EmployerSearch();
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = $employerModel->getEmployer($loggedin);
        $employerID = $employer2->employer_id;		
		$getGrossSalaryStatus=\frontend\modules\repayment\models\EmployedBeneficiary::getBeneficiaryGrossSalaryStatus($employerID);
		if($getGrossSalaryStatus >0){
		$sms="Error: Please set GROSS SALARY to all beneficiaries! Thanks!";
        Yii::$app->getSession()->setFlash('error', $sms);	
		return $this->redirect(['beneficiaries-payschedule']);	
		}else{
			\frontend\modules\repayment\models\EmployedBeneficiary::getAllBeneficiary($employerID);
		}
		
        $sms="Operation Successful!";
        Yii::$app->getSession()->setFlash('success', $sms);	
		return $this->redirect(['beneficiaries-payschedule']);
    }
	

}
