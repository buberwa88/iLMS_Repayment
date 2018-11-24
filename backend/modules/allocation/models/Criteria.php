<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "criteria".
 *
 * @property integer $criteria_id
 * @property string $criteria_description
 * @property integer $is_active
 *
 * @property CriteriaField[] $criteriaFields
 * @property CriteriaQuestion[] $criteriaQuestions
 */
class Criteria extends \yii\db\ActiveRecord {

    const STATUS_ACTIVE=1;
    const STATUS_INACTIVE=0;

        /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'criteria';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['criteria_description', 'is_active'], 'required'],
            [['is_active', 'criteria_origin'], 'safe'],
            [['criteria_description'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'criteria_id' => 'Criteria ID',
            'criteria_description' => 'Criteria Description',
            'is_active' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaFields() {
        return $this->hasMany(CriteriaField::className(), ['criteria_id' => 'criteria_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaQuestions() {
        return $this->hasMany(CriteriaQuestion::className(), ['criteria_id' => 'criteria_id']);
    }

    public static function getResponse($table_code) {
        $modeltable = \backend\modules\application\models\QresponseSource::findone($table_code);
        $data2 = self::findBySql("SELECT $modeltable->source_table_value_field AS id, $modeltable->source_table_text_field AS name FROM  $modeltable->source_table")->asArray()->all();
        $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
        return $value2;
    }

    public static function getTableColumnName($table_name) {
        $tablecolumn = \yii::$app->db->getTableSchema($table_name)->getColumnNames();
        foreach ($tablecolumn as $value) {
            $data2[] = array('id' => $value, 'name' => $value);
        }
        //print_r($tablecolumn);
        $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
        return $value2;
    }

    public static function getCriteriaQuestion($type) {

        return Yii::$app->db->createCommand("SELECT * from `criteria_question` cq 
                                                     join `criteria_question_answer` ca on 
                                                     ca.`criteria_question_id`=cq.`criteria_question_id` 
                                                     join  `qresponse_source` qs on
                                                     qs.`qresponse_source_id`=ca.`qresponse_source_id` WHERE `type`='{$type}' AND parent_id IS NULL")->queryAll();
    }

    public static function getCriteriaQuestionChild($parentId, $type) {

        return Yii::$app->db->createCommand("SELECT * from `criteria_question` cq 
                                                     join `criteria_question_answer` ca on 
                                                     ca.`criteria_question_id`=cq.`criteria_question_id` 
                                                     join  `qresponse_source` qs on
                                                     qs.`qresponse_source_id`=ca.`qresponse_source_id` WHERE `type`='{$type}' AND parent_id='{$parentId}'")->queryAll();
    }

    public function getCriteriaPosibleQuestionAnswer($source_table, $source_table_value_field, $response_id, $response_value) {
        $values = "";

        $data2 = Yii::$app->db->createCommand("SELECT * FROM $source_table where $source_table_value_field='{$response_id}' ")->queryAll();
        if (count($data2) > 0) {
            foreach ($data2 as $rows)
                ;
            $values = $rows["$response_value"];
        }
        return $values;
    }

    public function getApplicantCriteriaQuestionAnswer($source_table, $source_table_value_field, $response_id, $response_value, $operator, $answer_value) {

        if ($operator == "") {
            $operator = '=';
        }
        $values = Yii::$app->db->createCommand("SELECT count(*) as count FROM $source_table where $source_table_value_field='{$response_id}' AND $response_value $operator '{$answer_value}'")->queryScalar();

        return $values;
    }

    public static function getCriteriaFieldQuestion($type, $applicant_category_id, $academic_year_id) {
//    echo "SELECT * from criteria_field cf join criteria c on cf.criteria_id=c.criteria_id  WHERE `type`='{$type}' AND academic_year_id='{$academic_year_id}' AND applicant_category_id='{$applicant_category_id}' AND parent_id IS NULL";   
//    exit();
        return Yii::$app->db->createCommand("SELECT * from criteria_field cf join criteria c on cf.criteria_id=c.criteria_id  WHERE `type`='{$type}' AND academic_year_id='{$academic_year_id}' AND applicant_category_id='{$applicant_category_id}' AND parent_id IS NULL")->queryAll();
    }

    public function TestApplicantCriteriaFieldAnswer($source_table, $source_table_value_field, $response_value, $operator, $applicationId) {
        //  echo $applicationId;
        $testvalue = "application_id='{$applicationId}'";
        if ($source_table == "applicant") {
            $model = \backend\modules\application\models\Application::findOne($applicationId);

            $applicant_id = $model->applicant_id;
            $testvalue = "applicant_id='{$applicant_id}'";
            //echo "SELECT count(*) as count FROM $source_table where $source_table_value_field $operator '{$response_value}' AND $testvalue";
            //exit();
        }

        $values = Yii::$app->db->createCommand("SELECT count(*) as count FROM $source_table where $source_table_value_field $operator '{$response_value}' AND $testvalue")->queryScalar();
        return $values;
    }

    public static function getCriteriaFieldChild($parentId, $type) {

        return Yii::$app->db->createCommand("SELECT * from criteria_field  WHERE parent_id='{$parentId}' AND `type`='{$type}'")->queryAll();
    }

    static function getAllocationSpecialGroups() {
        return self::find()
        ->join('INNER JOIN', 'criteria_field', 'criteria_field.criteria_id=criteria.criteria_id')
        ->where(['is_active' => 1])
        ->andWhere(['criteria_field.type' => 4])
        ->asArray()->all();
    }

}
