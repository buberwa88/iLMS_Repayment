<?php

namespace backend\modules\report\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "erp_report".
 *
 * @property string $id
 * @property string $name
 * @property string $category
 * @property string $file_name
 * @property string $field1
 * @property string $field2
 * @property string $field3
 * @property string $field4
 * @property string $field5
 * @property string $type1
 * @property string $type2
 * @property string $type3
 * @property string $type4
 * @property string $type5
 * @property string $description1
 * @property string $description2
 * @property string $description3
 * @property string $description4
 * @property string $description5
 * @property string $sql
 * @property string $sql_where
 * @property string $sql_order
 * @property string $sql_group
 * @property string $column1
 * @property string $column2
 * @property string $column3
 * @property string $column4
 * @property string $column5
 * @property string $condition1
 * @property string $condition2
 * @property string $condition3
 * @property string $condition4
 * @property string $condition5
 * @property string $package
 */
class Report extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    const OPERATOR_EQUAL_TO = '=';
    const OPERATOR_NOT_EQUAL_TO = '<>';
    const OPERATOR_LIKE = 'like';
    const OPERATOR_GREATER_THAN = '>';
    const OPERATOR_GREATER_THAN_OR_EQUAL = '>=';
    const OPERATOR_LESS_THAN = '<';
    const OPERATOR_LESS_THAN_OR_EQUAL = '<=';
    const OPERATOR_TEXT = 'text';
    const OPERATOR_NUMERICAL = 'numerical';
    const OPERATOR_DATE = 'date';
    const OPERATOR_SEPARATOR = ' ';
    const OPERATOR_APPLICANT_CATEGORY = 'applicant_category';
    const OPERATOR_SEX = 'sex';
    const OPERATOR_INSTITUTION = 'institution';
    const OPERATOR_LOAN_ITEM = 'loan_item';
//const OPERATOR_STUDY_REGION = 'study_region';
    const OPERATOR_COUNTRY = 'country';
    const OPERATOR_PROGRAMME_GROUP = 'programme_group';
    const OPERATOR_SCHOLARSHIP_TYPE = 'scholarship_type';
    const OPERATOR_ACADEMIC_YEAR = 'academic_year';
    const OPERATOR_ALLOCATION_BATCH = 'allocation_batch';
    const OPERATOR_YEAR_OF_STUDY = 'year_of_study';
    const OPERATOR_CLUSTER_DEFINITION = 'cluster_definition';
	const OPERATOR_BOX_FILE = 'form_storage';
	const OPERATOR_USER = 'user';
    const FIELD_DATA_TYPE_TEXT = 'text';
    const FIELD_DATA_TYPE_INTEGER = 'numerical';
    const ROW_FILTER_5 = '5';
    const ROW_FILTER_6 = '6';
    const ROW_FILTER_7 = '7';
    const ROW_FILTER_8 = '8';
    const ROW_FILTER_9 = '9';
    const ROW_FILTER_10 = '10';
    const ROW_FILTER_11 = '11';
    const ROW_FILTER_12 = '12';
    const ROW_FILTER_13 = '13';
    const ROW_FILTER_14 = '14';
    const ROW_FILTER_15 = '15';
    const GSPP_EMPLOYEES_STATUS = 'gspp_employees_status';
    const PAYER_TYPE_EMPLOYER_TREASURY = 'payer_type_employer_treasury';
    const IMAGE_PLACEHOLDER = '/images/default_user.jpg';

    const CHECKED_STATUS_0 = 0;
    const CHECKED_STATUS_1 = 1;
    const CHECKED_STATUS_2 = 2;
    const CHECKED_STATUS_3 = 3;
    const CHECKED_STATUS_4 = 4;

    const PAYER_TYPE_SELF_EMPLOYER = 0;
    const PAYER_TYPE_TREASURY = 1;

    public static function tableName() {
        return 'report';
    }

    /**
     * @inheritdoc
     */
    public $file_field;
    public $input1;
    public $input2;
    public $input3;
    public $input4;
    public $input5;
    public $input6;
    public $input7;
    public $input8;
    public $input9;
    public $input10;
    public $input11;
    public $input12;
    public $input13;
    public $input14;
    public $input15;
    public $reportStartDate;
    public $reportEndDate;
    public $pageOrientation;
    public $uniqid;
    public $exportCategory;
    public $pageIdentify;
    ////aditional fields for report purpose
    public $parent;
    public $loan_item_id;
    public $item_code;
    public $allocated_amount;
    public $totalClusterCount;
    public $student_percentage_distribution;
    public $institution_type;
    public $publicPrivateDistr;
    public $female_percentage;
    public $male_percentage;
    public $studentsAdmission;
    public $hasAdmissionApplicant;
    public $hasAdmissionNonApplicant;
    public $minimumAllocated;
    public $maxmumAllocated;
    public $total_female;
    public $total_male;
    public $other;
    public $totalAllocated;
    public $totalStudentsPerCluster;
    public $total_allocated_amount;
    public $admissionWithNoInstitutions;
	public $export_mode;
	public $pageRedirect;

    public function rules() {
        return [
            [['name', 'category', 'sql', 'package','student_printview','printing_mode','excel_printing_mode'], 'required'],
            //[['exportCategory'], 'required','on'=>'exportReport'],
            [['category'], 'integer'],
            [['sql', 'sql_subquery', 'sql_subquery_where', 'sql_subquery_order', 'sql_subquery_group', 'sql_where', 'sql_order', 'sql_group', 'sql_params', 'package'], 'string'],
            [['name', 'file_name', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'field9', 'field10', 'field11', 'field12', 'field13', 'field14', 'field15', 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type7', 'type8', 'type9', 'type10', 'type11', 'type12', 'type13', 'type14', 'type15', 'description1', 'description2', 'description3', 'description4', 'description5', 'description6', 'description7', 'description8', 'description9', 'description10', 'description11', 'description12', 'description13', 'description14', 'description15', 'column1', 'column2', 'column3', 'column4', 'column5', 'column6', 'column7', 'column8', 'column9', 'column10', 'column11', 'column12', 'column13', 'column14', 'column15', 'condition1', 'condition2', 'condition3', 'condition4', 'condition5', 'condition6', 'condition7', 'condition8', 'condition9', 'condition10', 'condition11', 'condition12', 'condition13', 'condition14', 'condition15', 'field_data_type1', 'field_data_type2', 'field_data_type3', 'field_data_type4', 'field_data_type5', 'field_data_type6', 'field_data_type7', 'field_data_type8', 'field_data_type9', 'field_data_type10', 'field_data_type11', 'field_data_type12', 'field_data_type13', 'field_data_type14', 'field_data_type15'], 'string', 'max' => 200],
            [['name', 'file_name', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'field9', 'field10', 'field11', 'field12', 'field13', 'field14', 'field15'], 'validateReportFields'],
            [['sql_subquery', 'file_field', 'input1', 'input2', 'input3', 'input4', 'input5', 'input6', 'input7', 'input8', 'input9', 'input10', 'input11', 'input12', 'input13', 'input14', 'input15', 'reportStartDate', 'reportEndDate', 'pageOrientation', 'uniqid', 'exportCategory', 'pageIdentify','student_printview','printing_mode','export_mode','pageRedirect','excel_printing_mode'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Report Name',
            'category' => 'Module',
            'file_name' => 'File Name',
            'field1' => 'Field1',
            'field2' => 'Field2',
            'field3' => 'Field3',
            'field4' => 'Field4',
            'field5' => 'Field5',
            'field6' => 'Field6',
            'field7' => 'Field7',
            'field8' => 'Field8',
            'field9' => 'Field9',
            'field10' => 'Field10',
            'field11' => 'Field11',
            'field12' => 'Field12',
            'field13' => 'Field13',
            'field14' => 'Field14',
            'field15' => 'Field15',
            'type1' => 'Type1',
            'type2' => 'Type2',
            'type3' => 'Type3',
            'type4' => 'Type4',
            'type5' => 'Type5',
            'type6' => 'Type6',
            'type7' => 'Type7',
            'type8' => 'Type8',
            'type9' => 'Type9',
            'type10' => 'Type10',
            'type11' => 'Type11',
            'type12' => 'Type12',
            'type13' => 'Type13',
            'type14' => 'Type14',
            'type15' => 'Type15',
            'description1' => 'Description1',
            'description2' => 'Description2',
            'description3' => 'Description3',
            'description4' => 'Description4',
            'description5' => 'Description5',
            'description6' => 'Description6',
            'description7' => 'Description7',
            'description8' => 'Description8',
            'description9' => 'Description9',
            'description10' => 'Description10',
            'description11' => 'Description11',
            'description12' => 'Description12',
            'description13' => 'Description13',
            'description14' => 'Description14',
            'description15' => 'Description15',
            'sql' => 'Sql',
            'sql_subquery' => 'SQL Sub-query',
            'sql_where' => 'Sql Where',
            'sql_order' => 'Sql Order',
            'sql_group' => 'Sql Group',
            'sql_params' => 'Sql Params',
            'sql_subquery_where' => 'sql_subquery_where',
            'sql_subquery_order' => 'sql_subquery_order',
            'sql_subquery_group' => 'sql_subquery_group',
            'column1' => 'Column1',
            'column2' => 'Column2',
            'column3' => 'Column3',
            'column4' => 'Column4',
            'column5' => 'Column5',
            'column6' => 'Column6',
            'column7' => 'Column7',
            'column8' => 'Column8',
            'column9' => 'Column9',
            'column10' => 'Column10',
            'column11' => 'Column11',
            'column12' => 'Column12',
            'column13' => 'Column13',
            'column14' => 'Column14',
            'column15' => 'Column15',
            'condition1' => 'Condition1',
            'condition2' => 'Condition2',
            'condition3' => 'Condition3',
            'condition4' => 'Condition4',
            'condition5' => 'Condition5',
            'condition6' => 'Condition6',
            'condition7' => 'Condition7',
            'condition8' => 'Condition8',
            'condition9' => 'Condition9',
            'condition10' => 'Condition10',
            'condition11' => 'Condition11',
            'condition12' => 'Condition12',
            'condition13' => 'Condition13',
            'condition14' => 'Condition14',
            'condition15' => 'Condition15',
            'field_data_type1' => 'field_data_type1',
            'field_data_type2' => 'field_data_type2',
            'field_data_type3' => 'field_data_type3',
            'field_data_type4' => 'field_data_type4',
            'field_data_type5' => 'field_data_type5',
            'field_data_type6' => 'field_data_type6',
            'field_data_type7' => 'field_data_type7',
            'field_data_type8' => 'field_data_type8',
            'field_data_type9' => 'field_data_type9',
            'field_data_type10' => 'field_data_type10',
            'field_data_type11' => 'field_data_type11',
            'field_data_type12' => 'field_data_type12',
            'field_data_type13' => 'field_data_type13',
            'field_data_type14' => 'field_data_type14',
            'field_data_type15' => 'field_data_type15',
            'package' => 'Narration',
            'file_name' => 'Report Template',
            'file_field' => 'Report Template',
			'student_printview'=>'Show In Student Printing',
			'printing_mode'=>'Printing Mode',
			'export_mode'=>'Export Mode',
            'excel_printing_mode'=>'excel_printing_mode',
        ];
    }

    function validateReportFields() {
        $errorr_row = $no_errorr_row = 0;
        for ($i = 1; $i <= 15; $i++) {
            $field_label = trim('field' . $i);
            $field_type = trim('type' . $i);
            $field_data_type = trim('field_data_type' . $i);
            $description = trim('description' . $i);
            $column = trim('column' . $i);
            $condition = trim('condition' . $i);
            if (!empty($this->$field_label) OR ! empty($this->$field_type) OR ! empty($this->$field_data_type) OR ! empty($this->$description) OR ! empty($this->$column) OR ! empty($this->$condition)) {
                if (empty($this->$field_label) OR empty($this->$field_type) OR empty($this->$field_data_type) OR empty($this->$description) OR empty($column) OR empty($this->$condition)) {
                    $errorr_row++;
                } else {
                    $no_errorr_row++;
                }
            }
        }
        if ($errorr_row > 0 OR $no_errorr_row == 0) {
            $this->addError($attribute, 'Error: Please ensure all the fields are correctly set');
            return FALSE;
        }
    }

    static function getOperatorsCondition() {
        return [self::OPERATOR_EQUAL_TO => 'Equal To (=)',
            self::OPERATOR_LIKE => 'Contains <Like>',
            self::OPERATOR_NOT_EQUAL_TO => 'Not Equal To (<>)',
            self::OPERATOR_GREATER_THAN => 'Greater Than (>)',
            self::OPERATOR_GREATER_THAN_OR_EQUAL => 'Greater Than or Equal (>=)',
            self::OPERATOR_LESS_THAN => 'Less than (<)',
            self::OPERATOR_LESS_THAN_OR_EQUAL => 'Less than or Equal (<=)'
        ];
    }

    static function gsppEmployeeStatus() {
        return [
            self::CHECKED_STATUS_0 => 'Pending',
            self::CHECKED_STATUS_1 => 'Beneficiary not onrepayment',
            self::CHECKED_STATUS_2 => 'Beneficiary onrepayment',
            self::CHECKED_STATUS_3 => 'Nonbeneficiary',
            self::CHECKED_STATUS_4 => 'Checked employee onrepayment',
        ];
    }

    static function getOperatorsType() {
        return [self::OPERATOR_TEXT => 'Text',
            //self::OPERATOR_NUMERICAL => 'Numerical',
            self::OPERATOR_DATE => 'Date Picker',
            self::OPERATOR_SEPARATOR => '-----Dropdown-----',
            self::OPERATOR_APPLICANT_CATEGORY => 'Applicant Category',
            self::OPERATOR_SEX => 'Sex',
            self::OPERATOR_INSTITUTION => 'Institution',
            self::OPERATOR_LOAN_ITEM => 'Loan Item',
            //self::OPERATOR_STUDY_REGION => 'Study Region',
            self::OPERATOR_COUNTRY => 'Country',
            self::OPERATOR_PROGRAMME_GROUP => 'Programme Group',
            self::OPERATOR_SCHOLARSHIP_TYPE => 'Scholarship Type',
            self::OPERATOR_ACADEMIC_YEAR => 'Academic Year',
            self::OPERATOR_ALLOCATION_BATCH => 'Allocation Batch',
            self::OPERATOR_YEAR_OF_STUDY => 'Year of study',
            self::OPERATOR_CLUSTER_DEFINITION => 'Cluster Name',
			self::OPERATOR_BOX_FILE => 'Box File',
			self::OPERATOR_USER => 'User',
            self::GSPP_EMPLOYEES_STATUS => 'GSPP Employee Status',
            self::PAYER_TYPE_EMPLOYER_TREASURY => 'Repayment Payer Type',
        ];
    }

    static function getFieldDataType() {
        return [self::FIELD_DATA_TYPE_TEXT => 'Text',
            self::FIELD_DATA_TYPE_INTEGER => 'Numerical',
        ];
    }

    static function getFilterRows() {
        return [self::ROW_FILTER_5 => '5',
            self::ROW_FILTER_6 => '6',
            self::ROW_FILTER_7 => '7',
            self::ROW_FILTER_8 => '8',
            self::ROW_FILTER_9 => '9',
            self::ROW_FILTER_10 => '10',
            self::ROW_FILTER_11 => '11',
            self::ROW_FILTER_12 => '12',
            self::ROW_FILTER_13 => '13',
            self::ROW_FILTER_14 => '14',
            self::ROW_FILTER_15 => '15',
        ];
    }

    public function getDisplayImage() {
        if (empty($model->file_name)) {
// if you do not want a placeholder
            $image = null;

// else if you want to display a placeholder
            $image = Html::img(self::IMAGE_PLACEHOLDER, [
                        'alt' => Yii::t('app', 'No avatar yet'),
                        'title' => Yii::t('app', 'Upload your avatar by selecting browse below'),
                        'class' => 'file-preview-image'
// add a CSS class to make your image styling consistent
            ]);
        } else {
            $image = Html::img(Yii::$app->params['reportTemplate'] . $model->file_name, [
                        'alt' => Yii::t('app', 'Avatar for ') . $model->file_name,
                        'title' => Yii::t('app', 'Click remove button below to remove this image'),
                        'class' => 'file-preview-image'
// add a CSS class to make your image styling consistent
            ]);
        }

// enclose in a container if you wish with appropriate styles
        return ($image == null) ? null :
                Html::tag('div', $image, ['class' => 'file-preview-frame']);
    }

    public function deleteImage() {
        $image = Yii::$app->params['reportTemplate'] . $this->file_name . ".php";
        if (unlink($image)) {
            $this->file_name = null;
            $this->save();
            return true;
        }
        return false;
    }

    static function getUserRoles() {
        return self::findBySql('SELECT DISTINCT parent FROM auth_item_child')->all();
    }

    public static function getLoanItemNames11($applicantCategory = NULL) {
        if ($applicantCategory) {
            $loanItems = \backend\modules\allocation\models\LoanItem::findBySql('SELECT loan_item.loan_item_id AS loan_item_id,loan_item.item_code AS item_code FROM loan_item INNER JOIN loan_item_detail ON  loan_item.loan_item_id=loan_item_detail.loan_item_id WHERE place_of_study=:place_of_study AND loan_item_detail.study_level =:study_level AND loan_item_detail.loan_item_category=:loan_item_category', [':study_level' => $applicantCategory,':place_of_study' => 'local', ':loan_item_category' => 'normal'])
                    ->groupBy(['loan_item_detail.loan_item_id'])
                            ->orderBy(['loan_item.loan_item_id' => SORT_ASC, 'loan_item.item_code' => SORT_ASC])->all();
        } else {
            /*
            $loanItems = \backend\modules\allocation\models\LoanItem::find()
                            ->select(['loan_item_id', 'item_code'])
                            ->where(['place_of_study'=>'local'])
                            ->orderBy(['loan_item_id' => SORT_ASC, 'item_code' => SORT_ASC])->all();
             */
            /*
            $loanItems = \backend\modules\allocation\models\LoanItem::findBySql('SELECT loan_item.loan_item_id AS loan_item_id,loan_item.item_code AS item_code FROM loan_item INNER JOIN loan_item_detail ON  loan_item.loan_item_id=loan_item_detail.loan_item_id WHERE loan_item_detail.place_of_study=:place_of_study AND loan_item_detail.loan_item_category=:loan_item_category', [':place_of_study' => 'local',':loan_item_category' => 'normal'])
                            ->groupBy(['loan_item_detail.loan_item_id'])
                            ->orderBy(['loan_item.loan_item_id' => SORT_ASC, 'loan_item.item_code' => SORT_ASC])->all();
             * 
             */
            $loanItems = \backend\modules\allocation\models\LoanItem::findBySql("SELECT loan_item.loan_item_id AS loan_item_id,loan_item.item_code AS item_code FROM loan_item INNER JOIN loan_item_detail ON loan_item.loan_item_id=loan_item_detail.loan_item_id WHERE loan_item_detail.place_of_study='local' AND loan_item_detail.loan_item_category='normal' GROUP BY loan_item_detail.loan_item_id")->all();
             
             
            
        }
        return $loanItems;
    }
    public function getReportAccess()
    {
        return $this->hasMany(ReportAccess::className(), ['report_id' => 'id']);
    }
    
    
    public static function getLoanItemNames($applicantCategory = NULL) {
        if ($applicantCategory) {
            $loanItems = \backend\modules\allocation\models\LoanItem::findBySql('SELECT loan_item.loan_item_id AS loan_item_id,loan_item.item_code AS item_code FROM loan_item INNER JOIN loan_item_detail ON  loan_item.loan_item_id=loan_item_detail.loan_item_id WHERE loan_item_detail.study_level=1 AND loan_item_detail.study_level =:study_level AND loan_item_detail.loan_item_category=:loan_item_category', [':study_level' => $applicantCategory, ':loan_item_category' => 'normal'])
                            ->orderBy(['loan_item_detail.list_order' => SORT_ASC])->all();
        } else {
            /*
            $loanItems = \backend\modules\allocation\models\LoanItem::findBySql("SELECT loan_item.loan_item_id AS loan_item_id,loan_item.item_code AS item_code FROM loan_item INNER JOIN loan_item_detail ON loan_item.loan_item_id=loan_item_detail.loan_item_id WHERE loan_item_detail.study_level=1 AND loan_item_detail.place_of_study='local' AND loan_item_detail.loan_item_category='normal' GROUP BY loan_item_detail.loan_item_id")
                    ->orderBy(['loan_item_detail.list_order' => SORT_ASC])->all();
        }
             * 
             */
            $loanItems= \backend\modules\allocation\models\LoanItem::findBySql("SELECT loan_item.loan_item_id AS loan_item_id,loan_item.item_code AS item_code FROM loan_item join loan_item_detail on loan_item_detail.loan_item_id=loan_item.loan_item_id where  loan_item_detail.study_level=1 AND loan_item_detail.loan_item_category='normal' group by loan_item.loan_item_id order by list_order ASC")->all();
        }
        return $loanItems;
    }
    

    public static function getLoanItemAmount($loan_item_id) {

        $loanItemsAmount = \backend\modules\allocation\models\LoanItem::find()
                        ->where(['loan_item_id' => $loan_item_id])
                        ->orderBy(['loan_item_id' => SORT_ASC])->count();
        return $loanItemsAmount;
    }

    /*
     * returns the sub query results in array form based on the subquery sql and paramaters lis
     * $params should be an array of masked fieled as per sub query masked fiedls values
     * e.g array(':learning_institution_id' => $row['learning_institution_id'])
     */

    public static function getSubQueryItemsByRowId($sql_subquery, $sub_query_params) {
        return self::findBySql($sql_subquery, $sub_query_params)->asArray()->all();
    }
/*
    public static function getMaxNumberOfYrOfStudy($academicYear=NULL, $programme_id = NULL, $learningInstitution = NULL, $YoS = NULL) {
        $where = '';
        $params = [':academic_year_id' => $academicYear];

        if ($programme_id) {
            $where.= ' AND programme_cost.academic_year_id=:academic_year_id';
            $params = [':programme_id' => $programme_idr];
        }

        if ($learningInstitution) {
            $where.= ' AND programme_cost.learning_institution_id=:learning_institution_id';
            $params = [':learning_institution_id' => $learningInstitution];
        }
        if ($YoS) {
            $where.= ' AND programme_cost.year_of_study=:year_of_study';
            $params = [':year_of_study' => $YoS];
        }
        $sql = 'SELECT years_of_study FROM programme INNER JOIN programme_cost ON  programme.programme_id=programme_cost.programme_id
                WHERE programme_cost.academic_year_id=:academic_year_id';
        $yearsofstudy = \backend\modules\allocation\models\Programme::findBySql($sql, $params)
                        ->orderBy(['years_of_study' => SORT_DESC])->one();

        return $yearsofstudy;
    }
   */ 
    public static function getMaxNumberOfYrOfStudy($academicYear) {
        $yearsofstudy = \backend\modules\allocation\models\Programme::findBySql('SELECT MAX(years_of_study) AS years_of_study FROM programme INNER JOIN programme_cost ON  programme.programme_id=programme_cost.programme_id WHERE programme_cost.academic_year_id=:academic_year_id',[':academic_year_id'=>$academicYear])
                            ->one();

        return $yearsofstudy;
    }
    
    public static function getCountClusters($cluster_definition_id) {
            $clusterCountResults = self::findBySql("SELECT 
COUNT(CASE WHEN cluster_programme.cluster_definition_id > 0 THEN 1 ELSE NULL END) AS totalClusterCount
FROM  allocation_batch_student 
INNER JOIN allocation_batch ON allocation_batch.allocation_batch_id=allocation_batch_student.allocation_batch_id
INNER JOIN cluster_programme ON cluster_programme.programme_id=allocation_batch_student.programme_id
INNER JOIN programme_category ON programme_category.programme_category_id=cluster_programme.programme_category_id
INNER JOIN programme ON programme.programme_id=allocation_batch_student.programme_id
INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id
RIGHT JOIN cluster_definition ON cluster_definition.cluster_definition_id=cluster_programme.cluster_definition_id
WHERE allocation_batch.is_canceled=0 AND allocation_batch.academic_year_id=1 AND (learning_institution.ownership=0 OR  learning_institution.ownership=1)
AND cluster_programme.programme_id=allocation_batch_student.programme_id AND cluster_programme.cluster_definition_id='".$cluster_definition_id."' GROUP BY cluster_programme.programme_category_id,cluster_programme.cluster_definition_id")->all();    
        return count($clusterCountResults);
    }
    public static function getAllocationPlanClusterSetting($cluster_definition_id){
     $cluster = self::findBySql("SELECT 
student_percentage_distribution
FROM  allocation_plan_cluster_setting 
WHERE allocation_plan_cluster_setting.cluster_definition_id='".$cluster_definition_id."'")->one();    
        return $cluster;   
    }
    public static function getPublicPrivateDistrubution($academicYear){
     $publicPrivateD = self::findBySql("SELECT 
allocation_plan_institution_type_setting.institution_type AS 'institution_type',allocation_plan_institution_type_setting.student_distribution_percentage AS 'publicPrivateDistr'
FROM  allocation_plan_institution_type_setting INNER JOIN allocation_plan ON allocation_plan_institution_type_setting.allocation_plan_id=allocation_plan. 	allocation_plan_id   
WHERE allocation_plan.academic_year_id='".$academicYear."'")->all();    
        return $publicPrivateD;   
    }
    
    public static function getGetPrivatePublicGenderDistr($academicYear){
     $publicPrivateGender = self::findBySql("SELECT 
allocation_plan_gender_setting.female_percentage AS 'female_percentage',allocation_plan_gender_setting.male_percentage AS 'male_percentage'
FROM  allocation_plan_gender_setting INNER JOIN allocation_plan ON allocation_plan_gender_setting.allocation_plan_id=allocation_plan.allocation_plan_id   
WHERE allocation_plan.academic_year_id='".$academicYear."'")->one();    
        return $publicPrivateGender;   
    }
    
    public static function getAdmissionFigure($academicYear=NULL,$learningInstitution){
     $dataProviderAdmission= self::findBySql("SELECT COUNT(admission_student_id) AS studentsAdmission,COUNT(CASE WHEN admission_student.admission_status=1 THEN 1 ELSE NULL END) AS hasAdmissionApplicant,COUNT(CASE WHEN admission_student.admission_status=0 THEN 1 ELSE NULL END) AS hasAdmissionNonApplicant FROM admission_student INNER JOIN programme ON admission_student.programme_id=programme.programme_id 
WHERE 
admission_student.programme_id=programme.programme_id AND
admission_student.study_year =1 AND admission_student.academic_year_id=:academic_year_id AND programme.learning_institution_id=:learning_institution_id", [':learning_institution_id' =>$learningInstitution, ':academic_year_id' =>$academicYear])->one();  
        return $dataProviderAdmission;   
    }
    
    public static function getMaxMinAmountAllocated($academicYear) {
        $maxMin = self::findBySql('SELECT MIN(allocatedAmount) AS minimumAllocated,MAX(allocatedAmount) AS maxmumAllocated FROM (SELECT 
programme.programme_name,programme.programme_code,SUM(allocation.allocated_amount) AS allocatedAmount
FROM  allocation_batch_student 
INNER JOIN allocation_batch ON allocation_batch.allocation_batch_id=allocation_batch_student.allocation_batch_id
INNER JOIN programme ON programme.programme_id=allocation_batch_student.programme_id
INNER JOIN allocation ON allocation.allocation_batch_id=allocation_batch_student.allocation_batch_id
WHERE allocation_batch.is_canceled=0 AND allocation_batch.academic_year_id=:academic_year_id
GROUP BY allocation_batch_student.programme_id

ORDER BY allocatedAmount ASC) AS newAmount',[':academic_year_id'=>$academicYear])
                            ->one();

        return $maxMin;
    }
    
    public static function getAdmissionByGender($academicYear,$studyYear){
     $dataProviderAdmissionByGender= self::findBySql("SELECT COUNT(CASE WHEN gender='F' THEN 1 ELSE NULL END) as total_female, COUNT(CASE WHEN gender='M' THEN 1 ELSE NULL END) as total_male, COUNT(CASE WHEN (gender='' OR gender IS NULL)  THEN 1 ELSE NULL END) as other FROM admission_student 
WHERE 
admission_student.study_year =:study_year AND admission_student.academic_year_id=:academic_year_id", [':study_year' =>$studyYear, ':academic_year_id' =>$academicYear])->one();  
        return $dataProviderAdmissionByGender;   
    }
	public static function getAllocatedFromAdmission($learning_institution_id,$academicYear){
     $dataProviderAllocated= self::findBySql("SELECT COUNT(DISTINCT application_id) AS totalAllocated FROM allocation_batch_student
INNER JOIN programme ON programme.programme_id = allocation_batch_student.programme_id
INNER JOIN allocation_batch ON allocation_batch.allocation_batch_id= allocation_batch_student.allocation_batch_id WHERE 
allocation_batch.is_canceled='0' AND programme.programme_id= allocation_batch_student.programme_id AND
programme.learning_institution_id=:learning_institution_id
AND allocation_batch.academic_year_id=:academic_year_id", [':learning_institution_id' =>$learning_institution_id, ':academic_year_id' =>$academicYear])
             ->groupBy(['programme.learning_institution_id'])
             ->one();  
        return $dataProviderAllocated;   
    }
    
    public static function getCountPerCluster($cluster_definition_id,$academicYear,$batchNumber){
     $dataProviderTotalCount= self::findBySql("SELECT COUNT(DISTINCT application_id) AS totalStudentsPerCluster FROM `allocation_batch_student`
INNER JOIN allocation_batch ON allocation_batch.allocation_batch_id=allocation_batch_student.allocation_batch_id
WHERE
allocation_batch.allocation_batch_id=allocation_batch_student.allocation_batch_id AND
allocation_batch.is_canceled='0' AND allocation_batch.allocation_batch_id=:allocation_batch_id AND allocation_batch.academic_year_id=:academic_year_id AND allocation_batch_student.cluster_definition_id=:cluster_definition_id", [':allocation_batch_id' =>$batchNumber, ':academic_year_id' =>$academicYear,':cluster_definition_id' =>$cluster_definition_id])
             ->one();  
        return $dataProviderTotalCount;   
    }
    public static function getAllocatedAmountPerInstitution($learning_institution_id,$academicYear){
     $dataProviderAllocated= self::findBySql("SELECT SUM(allocated_amount)  AS total_allocated_amount
FROM allocation
INNER JOIN allocation_batch_student ON allocation.application_id=allocation_batch_student.application_id
INNER JOIN allocation_batch ON allocation_batch.allocation_batch_id=allocation.allocation_batch_id
INNER JOIN programme ON programme.programme_id=allocation_batch_student.programme_id
WHERE allocation.is_canceled='0' AND allocation_batch.is_canceled='0' AND allocation_batch.contained_student='1'
AND allocation_batch_student.allocation_batch_id=allocation.allocation_batch_id AND allocation.allocation_batch_id=allocation_batch.allocation_batch_id
AND programme.learning_institution_id=:learning_institution_id AND allocation_batch.academic_year_id=:academic_year_id", [':learning_institution_id' =>$learning_institution_id, ':academic_year_id' =>$academicYear])
             ->one();  
        return $dataProviderAllocated;   
    }
    
    public static function getAdmissionWithNoInstitution($academicYear){
     $admissionWithNoInstitutions= self::findBySql("SELECT count(*) AS admissionWithNoInstitutions
From
(
SELECT admission_student_id, programme.programme_id FROM `admission_student` LEFT JOIN programme on programme.programme_id=admission_student.programme_id
WHERE admission_student.study_year =1 AND admission_student.academic_year_id=:academic_year_id) As PQ

WHERE
PQ.programme_id IS NULL",[':academic_year_id' =>$academicYear])
             ->one();  
        return $admissionWithNoInstitutions;   
    }
    static function payerType() {
        return [
            self::PAYER_TYPE_SELF_EMPLOYER => 'Self Employer',
            self::PAYER_TYPE_TREASURY => 'Treasury',
        ];
    }

}
