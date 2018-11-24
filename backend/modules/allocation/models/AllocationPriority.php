<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\AllocationPriority as BaseAllocationPriority;

/**
 * This is the model class for table "allocation_priority".
 */
class AllocationPriority extends BaseAllocationPriority {

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['academic_year_id', 'source_table', 'field_value', 'priority_order', 'baseline', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['source_table_field'], 'string', 'max' => 30]
        ]);
    }

    function gettableColumnName($tableId) {
        $modeltable = SourceTable::findone($tableId);
        $data = array();
        if (count($modeltable) > 0) {
            $data2 = Yii::$app->db->createCommand("SELECT $modeltable->source_table_id_field AS id, $modeltable->source_table_text_field	AS name FROM  $modeltable->source_table_name")->queryAll();
            /// $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
            $data = array();
            foreach ($data2 as $rows) {
                $data[$rows["id"]] = $rows["name"];
            }
        }
        return $data;
        //print_r($value2);
    }

    function getSourceTableValue() {
        if ($this->source_table && $this->field_value) {
            
            return $this->field_value;
        }
        return NULL;
    }

}
