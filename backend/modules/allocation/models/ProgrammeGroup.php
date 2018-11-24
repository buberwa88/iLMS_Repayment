<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\ProgrammeGroup as BaseProgrammeGroup;

/**
 * This is the model class for table "programme_group".
 */
class ProgrammeGroup extends BaseProgrammeGroup {

    /// status constant value
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
               [['group_code', 'group_name'], 'required'],
               [['created_at', 'updated_at', 'created_by','updated_by', 'is_active'], 'safe'],
               [['created_by', 'updated_by'], 'integer'],
               [['group_code'], 'string', 'max' => 20], 
              // [['group_name'], 'string', 'max' => 150],
               ['group_name', 'string', 'min' => 2, 'max' => 150, 'message' => '{attribute} should be at least 2 symbols'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'group_code' => 'Group Code',
            'group_name' => 'Group Name ',
            'is_active' => 'is Active',
            'study_level' => 'Programme Level',
            'programme_group_desc' => 'Group Descripiton',
            'createdBy' => 'Created By',
            'updated_by' => 'Updated By'
        ];
    }

    /*
     * returns status in array key=>value format
     */

    static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Yes/Active', self::STATUS_INACTIVE => 'No/In-Active'
        ];
    }

    public function getStatusNameByValue() {
        if ($this->is_active >= 0) {
            $statuses = self::getStatusList();
            if (isset($statuses[$this->is_active])) {
                return $statuses[$this->is_active];
            }
        }
        return NULL;
    }

    public static function getProgrammeGoupByProgramCategoryAndAcademicYear($programme_category_id, $academic_year) {
        //get all programme in the academic year

        $data = self::find()
                ->select('programme_group_id,group_code,group_name,')
                ->where(['status' => self::STATUS_ACTIVE])
                ->join('inner', 'tbl_programme')
                ->join('inner', 'tbl_programme_catergory')
                ->all();

        $sql = "SELECT programme_group.programme_group_id, `group_code`, `group_name` 
              FROM `programme_group` 
              INNER JOIN programme ON programme.programme_id=programme_group.programme_group_id
              WHERE programme.programme_category_id IN('.$programme_category_id.')'";


        $modelprogram = Yii::$app->db->createCommand("SELECT group_concat(`programme_id`) as programmeId FROM `cluster_programme` WHERE `academic_year_id`='{$academic_year}'")->queryAll();
        $arraydata = "";
        $condition = "";
        if (count($modelprogram) > 0) {
            foreach ($modelprogram as $rows)
                ;
            $arraydata = $rows["programmeId"];
            $condition = " AND programme_id NOT IN($arraydata)";
        }

        $sql = Programme::find()->where("programme_category_id IN($programme_category_id) $condition")->asArray()->all();
        foreach ($sql as $rows) {
            $programme_id = $rows["programme_id"];
            $programme_name = $rows["programme_name"];
            $data2[] = array('id' => $programme_id, 'name' => $programme_name);
        }
        //print_r($tablecolumn);
        $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
        return $value2;
    }

   static function getGroupNameByID($ID) {
        $data = self::findOne($ID);
        if ($data) {
            return $data->group_name;
        }
        return NULL;
    }

    static function getProgrammeGroupByStatus($status, $study_level = NULL) {
        $condition = ['is_active' => $status,];
        if ($study_level) {
            $condition['study_level'] = $study_level;
        }
        return self::find()
                        ->where($condition)
                        ->asArray()
                        ->all();
    }

    static function getProgrammeActiveGroupsNotInClusters($academic_year, $study_level = NULL) {
        $condition = ' AND is_active = :is_active';
        $params = [
            ':is_active' => ProgrammeGroup::STATUS_ACTIVE,
            ':academic_year' => $academic_year
        ];
        if ($study_level) {
            $condition .= ' AND study_level = :study_level';
            $params[':study_level'] = $study_level;
        }
        $sql = 'SELECT * FROM programme_group
                WHERE programme_group_id NOT IN(SELECT programme_group_id FROM cluster_programme WHERE academic_year_id = :academic_year) ' . $condition;

        return self::findBySql($sql, $params)
                        ->asArray()
                        ->all();
    }

}
