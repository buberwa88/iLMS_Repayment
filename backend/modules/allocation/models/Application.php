<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property integer $application_id
 * @property integer $applicant_id
 * @property integer $academic_year_id
 * @property string $bill_number
 * @property string $control_number
 * @property string $receipt_number
 * @property double $amount_paid
 * @property string $pay_phone_number
 * @property string $date_bill_generated
 * @property string $date_control_received
 * @property string $date_receipt_received
 * @property integer $programme_id
 * @property integer $application_study_year
 * @property integer $current_study_year
 * @property integer $applicant_category_id
 * @property string $bank_account_number
 * @property string $bank_account_name
 * @property integer $bank_id
 * @property string $bank_branch_name
 * @property integer $submitted
 * @property integer $verification_status
 * @property double $needness
 * @property integer $allocation_status
 * @property string $allocation_comment
 * @property string $student_status
 * @property string $created_at
 * @property string $passport_photo_comment
 *
 * @property Allocation[] $allocations
 * @property ApplicantAssociate[] $applicantAssociates
 * @property ApplicantAttachment[] $applicantAttachments
 * @property ApplicantCriteriaScore[] $applicantCriteriaScores
 * @property ApplicantProgrammeHistory[] $applicantProgrammeHistories
 * @property ApplicantQuestion[] $applicantQuestions
 * @property AcademicYear $academicYear
 * @property Applicant $applicant
 * @property ApplicantCategory $applicantCategory
 * @property Bank $bank
 * @property Programme $programme
 * @property Disbursement[] $disbursements
 * @property Education[] $educations
 * @property InstitutionPaymentRequestDetail[] $institutionPaymentRequestDetails
 * @property Loan[] $loans
 */
class Application extends \backend\modules\application\models\Application {

    public $f4indexno;
    public $sex;

    /*
     * returns the total number of students eligible for loan in the given academic year
     */

    static function countEligibleFirstTimeApplicantsByAcademicYear($academic_year_id, $allocation_history_model = NULL) {
        $sql_exist_in_list = NULL;
        if (is_object($allocation_history_model)) {
            $sql_exist_in_list = " AND application.application_id NOT IN(
                 SELECT application_id 
                 FROM allocation_plan_student 
                 WHERE allocation_plan_student.total_allocated_amount>0 AND allocation_history_id=$allocation_history_model->loan_allocation_history_id
                 )  ";
        }
        $sql = "SELECT application.applicant_id
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY' 
                     AND application.current_study_year=1
                     AND application.transfer_status IN(0,2)  
                     AND admission_student.has_transfered IN(0,2) 
                     AND application.allocation_status=6 
                     AND application.verification_status=1
                     AND application.needness>0  AND application.programme_cost>0
                     AND application.needness <= application.programme_cost
                     AND admission_student.programme_id=application.programme_id
                     AND admission_student.study_year=application.current_study_year
                     AND admission_student.academic_year_id=application.academic_year_id
                     AND admission_student.admission_status=2  
                     AND application.academic_year_id=$academic_year_id
                     AND application.programme_id IN(
                      SELECT programme_id FROM programme 
                      INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                      WHERE programme.is_active= " . Programme::STATUS_ACTIVE . "
                        AND programme.status = 2 AND learning_institution.country='TZA'
                      ) $sql_exist_in_list 
                    ";
      // exit();
        $sql = "SELECT application.applicant_id
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY' 
                     AND application.current_study_year=1
                     AND application.transfer_status IN(0,2)  
                     AND admission_student.has_transfered IN(0,2) 
                     AND application.allocation_status=6
                     AND application.verification_status=1
                     
                     AND application.academic_year_id=$academic_year_id
                     AND application.programme_id IN(
                      SELECT programme_id FROM programme 
                      INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                      WHERE programme.is_active= " . Programme::STATUS_ACTIVE . "
                        AND programme.status = 2 AND learning_institution.country='TZA'
                      ) $sql_exist_in_list 
                    ";

        return self::findBySql($sql)->count();
    }

    /*
     * returns a list of valid student based on special group
     */

    static function getLocalFreshersStudentForAllocationBySpecialGroupIdInCurrentAcademicYear($special_group_id, $allocation_history_model, $index_start = NULL, $index_end = NULL) {
        $sql_exist_in_list = NULL;
        if (is_object($allocation_history_model)) {
            $sql_exist_in_list = " AND application.application_id NOT IN(
                 SELECT application_id 
                 FROM allocation_plan_student 
                 WHERE allocation_plan_student.total_allocated_amount>0 AND allocation_history_id=$allocation_history_model->loan_allocation_history_id
                 )  ";
        }
        $sql = "SELECT application.application_id,application.applicant_id,application.registration_number,
                application.academic_year_id,application.programme_id, application.application_study_year,
                application.current_study_year,application.needness, application.programme_cost,
                application.myfactor,application.ability,application.fee_factor, application.student_fee,
                application.allocation_status, application.student_status, application.transfer_status,
                applicant.sex AS sex
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY' 
                     AND application.current_study_year=1
                     AND application.transfer_status IN(0,2)  
                     AND admission_student.has_transfered IN(0,2) 
                     AND application.allocation_status=6 
                     AND application.verification_status=1
                     AND application.needness >0  AND application.programme_cost>0
                     AND application.needness <= application.programme_cost
                     AND admission_student.programme_id=application.programme_id
                     AND admission_student.study_year=application.current_study_year
                     AND admission_student.academic_year_id=application.academic_year_id
                     AND admission_student.admission_status=2  
                     AND application.academic_year_id=$allocation_history_model->academic_year_id
                     AND application.programme_id IN(
                      SELECT programme_id FROM programme 
                      INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                      WHERE programme.is_active= " . Programme::STATUS_ACTIVE . "
                        AND programme.status = 2 AND learning_institution.country='TZA'
                      )   $sql_exist_in_list 
                     ORDER BY  application.needness DESC ";
        if ($index_start >= 0 && $index_end) {
            $sql .=" LIMIT " . $index_start . "," . $index_end;
        }

        return self::findBySql($sql)->all();
    }

    static function countLocalFreshersStudentForAllocationBySpecialGroupIdInCurrentAcademicYear($special_group_id, $allocation_history_model) {
        $sql_exist_in_list = NULL;
        if (is_object($allocation_history_model)) {
            $sql_exist_in_list = " AND application.application_id NOT IN(
                 SELECT application_id 
                 FROM allocation_plan_student 
                 WHERE allocation_plan_student.total_allocated_amount>0 AND allocation_history_id=$allocation_history_model->loan_allocation_history_id
                 )  ";
        }
        $sql = "SELECT application.applicant_id
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY' 
                     AND application.current_study_year=1
                     AND application.transfer_status IN(0,2)  
                     AND admission_student.has_transfered IN(0,2) 
                     AND application.allocation_status=6 
                     AND application.verification_status=1
                     AND application.needness>0  AND application.programme_cost>0
                     AND application.needness <= application.programme_cost
                     AND admission_student.programme_id=application.programme_id
                     AND admission_student.study_year=application.current_study_year
                     AND admission_student.academic_year_id=application.academic_year_id
                     AND admission_student.admission_status=2  
                     AND application.academic_year_id=$allocation_history_model->academic_year_id
                     AND application.programme_id IN(
                      SELECT programme_id FROM programme 
                      INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                      WHERE programme.is_active= " . Programme::STATUS_ACTIVE . "
                        AND programme.status = 2 AND learning_institution.country='TZA'
                      )   $sql_exist_in_list 
                    ";

//        echo $sql;

        return self::findBySql($sql)->count();
    }

    /*
     * returns counts of the students based on the cluster ID
     */

    static function countLocalFreshersStudentForAllocationByClusterIDAndCurrentAcademicYear($cluster_id, $allocation_history_model) {
        $sql_exist_in_list = NULL;
        if (is_object($allocation_history_model)) {
            $sql_exist_in_list = " AND application.application_id NOT IN(
                 SELECT application_id 
                 FROM allocation_plan_student 
                 WHERE allocation_plan_student.total_allocated_amount>0 AND allocation_history_id=$allocation_history_model->loan_allocation_history_id
                 )  ";
        }
        $sql_real = "SELECT application.applicant_id
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY' 
                     AND application.current_study_year=1
                     AND application.transfer_status IN(0,2)  
                     AND admission_student.has_transfered IN(0,2) 
                     AND application.allocation_status=6 
                     AND application.verification_status=1
                     AND application.needness>0  AND application.programme_cost>0
                     AND application.needness <= application.programme_cost
                     AND admission_student.programme_id=application.programme_id
                     AND admission_student.study_year=application.current_study_year
                     AND admission_student.academic_year_id=application.academic_year_id
                     AND admission_student.admission_status=2  
                     AND application.academic_year_id=$allocation_history_model->academic_year_id
                     AND application.programme_id IN(
                      SELECT cluster_programme.programme_id FROM cluster_programme 
                      INNER JOIN programme ON programme.programme_id=cluster_programme.programme_id
                      INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                      WHERE cluster_definition_id=$cluster_id 
                           AND cluster_programme.academic_year_id=$allocation_history_model->academic_year_id  
                        AND programme.is_active= " . Programme::STATUS_ACTIVE . "
                        AND programme.status = 2 AND learning_institution.country='TZA'
                      )
                        $sql_exist_in_list ORDER BY  application.needness DESC
                ";

        $sql = "SELECT application.applicant_id
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY'                      
                     AND application.programme_id IN(
                      SELECT cluster_programme.programme_id FROM cluster_programme 
                      INNER JOIN programme ON programme.programme_id=cluster_programme.programme_id
                      INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                      WHERE cluster_definition_id=$cluster_id 
                           AND cluster_programme.academic_year_id=$allocation_history_model->academic_year_id  
                        AND programme.is_active= " . Programme::STATUS_ACTIVE . "
                        AND programme.status = 2 AND learning_institution.country='TZA'
                      )
                        $sql_exist_in_list ORDER BY  application.needness DESC
                ";
//        echo $sql;

        return self::findBySql($sql)->count();
    }

    /*
     * returns the list of students eligible for allocation based on the clusterID
     */

    static function getLocalFreshersStudentForAllocationByClusterIDAndCurrentAcademicYear($cluster_id, $allocation_history_model, $index_start = NULL, $index_end = NULL) {
        $sql_exist_in_list = NULL;
        if (is_object($allocation_history_model)) {
            $sql_exist_in_list = " AND application.application_id NOT IN(
                 SELECT application_id 
                 FROM allocation_plan_student 
                 WHERE allocation_plan_student.total_allocated_amount>0 AND allocation_history_id=$allocation_history_model->loan_allocation_history_id
                 )  ";
        }
        $sql_real = "SELECT application.application_id,application.applicant_id,application.registration_number,
                application.academic_year_id,application.programme_id, application.application_study_year,
                application.current_study_year,application.needness, application.programme_cost,
                application.myfactor,application.ability,application.fee_factor, application.student_fee,
                application.allocation_status, application.student_status, application.transfer_status,
                applicant.sex AS sex
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY' 
                     AND application.current_study_year=1
                     AND application.transfer_status IN(0,2)  
                     AND admission_student.has_transfered IN(0,2) 
                     AND application.allocation_status=6 
                     AND application.verification_status=1
                     AND application.needness >0  AND application.programme_cost>0
                     AND application.needness <= application.programme_cost
                     AND admission_student.programme_id=application.programme_id
                     AND admission_student.study_year=application.current_study_year
                     AND admission_student.academic_year_id=application.academic_year_id
                     AND admission_student.admission_status=2  
                     AND application.academic_year_id=$allocation_history_model->academic_year_id
                     AND application.programme_id IN(
                      SELECT programme_id FROM cluster_programme 
                      INNER JOIN programme ON programme.programme_id=cluster_programme.programme_id
                      INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                      WHERE cluster_definition_id=$cluster_id 
                           AND cluster_programme.academic_year_id`=$allocation_history_model->academic_year_id  
                        AND programme.is_active= " . Programme::STATUS_ACTIVE . "
                        AND programme.status = 2 AND learning_institution.country='TZA' 
                      )
                        $sql_exist_in_list ORDER BY  application.needness DESC
                ";
        $sql = "SELECT *
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY'                      
                     AND application.programme_id IN(
                      SELECT cluster_programme.programme_id FROM cluster_programme 
                      INNER JOIN programme ON programme.programme_id=cluster_programme.programme_id
                      INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                      WHERE cluster_definition_id=$cluster_id 
                           AND cluster_programme.academic_year_id=$allocation_history_model->academic_year_id  
                        AND programme.is_active= " . Programme::STATUS_ACTIVE . "
                        AND programme.status = 2 AND learning_institution.country='TZA'
                      )
                        $sql_exist_in_list ORDER BY  application.needness DESC
                ";


        if ($index_start >= 0 && $index_end) {
            $sql .=" LIMIT " . $index_start . "," . $index_end;
        }
//        echo $sql; exit;

        return self::findBySql($sql)->all();
    }

    static function countLocalContunuingStudentForAllocationByAllocationModel($model) {
        $sql = "SELECT application.applicant_id
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY' 
                AND admission_student.academic_year_id>1
                AND application.transfer_status IN(0,2)  
                AND admission_student.has_transfered IN(0,2) 
                AND application.allocation_status=6 
                AND application.verification_status=1
                AND application.needness>0  AND application.programme_cost>0
                AND application.needness <= application.programme_cost
                AND admission_student.programme_id=application.programme_id
                AND admission_student.study_year=application.current_study_year
                AND admission_student.admission_status=2
                AND admission_student.academic_year_id=$model->academic_year_id
                AND admission_student.programme_id IN(
                    SELECT programme_id FROM programme 
                    INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                    WHERE programme.is_active= " . Programme::STATUS_ACTIVE . "
                    AND programme.status = 2 AND learning_institution.country='TZA'
                    ) 
                    ";
        return self::findBySql($sql)->count();
    }

    static function getLocalContunuingStudentForAllocationByAllocationModel($model, $index_start, $index_end) {
        $sql = "SELECT application.application_id,application.applicant_id,application.registration_number,
                application.academic_year_id,application.programme_id, application.application_study_year,
                application.current_study_year,application.needness, application.programme_cost,
                application.myfactor,application.ability,application.fee_factor, application.student_fee,
                application.allocation_status, application.student_status, application.transfer_status,
                applicant.f4indexno AS f4indexno
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY' 
               
                AND application.transfer_status IN(0,2)  
                AND admission_student.has_transfered IN(0,2) 
                AND application.allocation_status=6
                AND application.verification_status=1
                AND application.needness>0  AND application.programme_cost>0
                AND application.needness <= application.programme_cost
                AND admission_student.programme_id=application.programme_id
                AND admission_student.study_year=application.current_study_year
                AND admission_student.admission_status=2
                AND admission_student.academic_year_id=$model->academic_year_id
                AND admission_student.programme_id IN(
                    SELECT programme_id FROM programme 
                    INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                    WHERE programme.is_active= " . Programme::STATUS_ACTIVE . "
                    AND programme.status = 2 AND learning_institution.country='TZA'
                    ) 
                    ";
        if ($index_start >= 0 && $index_end) {
            $sql .=" LIMIT " . $index_start . "," . $index_end;
        }
        return self::findBySql($sql)->all();
    }

    /*
     * returns counts of the students based on GEnder Type,Cluster and Current Academic Year
     */

    static function countLocalFreshersStudentForAllocationByGenderAndCurrentAcademicYear($cluster_id = NULL, $allocation_history_model) {
        $sql_exist_in_list = $sql_exist_in_cluster = NULL;
        if (is_object($allocation_history_model)) {
            $sql_exist_in_list = " AND application.application_id NOT IN(
                 SELECT application_id 
                 FROM allocation_plan_student 
                 WHERE allocation_plan_student.total_allocated_amount>0 AND allocation_history_id=$allocation_history_model->loan_allocation_history_id
                 )  ";
        }
        if ($cluster_id) {
            $sql_exist_in_cluster = " AND application.programme_id  IN(
                      SELECT cluster_programme.programme_id FROM cluster_programme 
                      WHERE cluster_definition_id=$cluster_id   
                      AND cluster_programme.academic_year_id=$allocation_history_model->academic_year_id  
                      )";
        }
        $sql = "SELECT applicant.sex as sex,COUNT(application.applicant_id) AS applicant_id
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY' 
                      AND application.programme_id IN(
                      SELECT programme.programme_id FROM programme 
                       INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                       WHERE programme.is_active= " . Programme::STATUS_ACTIVE . "
                       AND programme.status = 2 AND learning_institution.country='TZA'
                       )
                     $sql_exist_in_list$sql_exist_in_cluster  GROUP BY sex
                ";
        return self::findBySql($sql)->count();
    }

    static function getLocalFreshersStudentForAllocationByCurrentAcademicYear($cluster_id = NULL, $allocation_history_model, $index_start, $index_end) {
        $sql_exist_in_list = $sql_exist_in_cluster = NULL;
        if (is_object($allocation_history_model)) {
            $sql_exist_in_list = " AND application.application_id NOT IN(
                 SELECT application_id 
                 FROM allocation_plan_student 
                 WHERE allocation_plan_student.total_allocated_amount>0 AND allocation_history_id=$allocation_history_model->loan_allocation_history_id
                 )  ";
        }
        if ($cluster_id) {
            $sql_exist_in_cluster = " AND application.programme_id  IN(
                      SELECT cluster_programme.programme_id FROM cluster_programme 
                      WHERE cluster_definition_id=$cluster_id 
                           AND cluster_programme.academic_year_id=$allocation_history_model->academic_year_id  
                      )";
        }


        $sql = "SELECT application.application_id,application.applicant_id,application.registration_number,
                application.academic_year_id,application.programme_id, application.application_study_year,
                application.current_study_year,application.needness, application.programme_cost,
                application.myfactor,application.ability,application.fee_factor, application.student_fee,
                application.allocation_status, application.student_status, application.transfer_status,
                applicant.f4indexno AS f4indexno, applicant.sex AS sex
                FROM application 
                INNER JOIN applicant ON applicant.applicant_id=application.applicant_id
                INNER JOIN admission_student ON admission_student.f4indexno=applicant.f4indexno
                WHERE application.student_status='ONSTUDY' 
                      AND application.programme_id IN(
                      SELECT programme.programme_id FROM programme 
                       INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
                       WHERE programme.is_active= " . Programme::STATUS_ACTIVE . "
                       AND programme.status = 2 AND learning_institution.country='TZA'
                       )
                      $sql_exist_in_list$sql_exist_in_cluster ORDER BY application.needness DESC
                ";
        if ($index_start >= 0 && $index_end) {
            $sql .=" LIMIT " . $index_start . "," . $index_end;
        }
//        echo $sql;
        return self::findBySql($sql)->all();
    }

}
