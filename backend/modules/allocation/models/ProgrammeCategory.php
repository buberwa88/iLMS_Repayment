<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "programme_category".
 *
 * @property integer $programme_category_id
 * @property string $programme_category_name
 * @property string $programme_category_desc
 *
 * @property ClusterProgramme[] $clusterProgrammes
 */
class ProgrammeCategory extends \yii\db\ActiveRecord {

    /// status constant value
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'programme_category';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['programme_category_name','programme_category_desc'], 'required'],
            [['programme_category_name'], 'string', 'max' => 45],
            [['programme_category_desc'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'programme_category_id' => 'Programme Category',
            'programme_category_name' => 'Category Name',
            'programme_category_desc' => 'Category Desc',
            'is_active'=>'Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusterProgrammes() {
        return $this->hasMany(ClusterProgramme::className(), ['sub_cluster_definition_id' => 'programme_category_id']);
    }

    /*
     * returns status in array key=>value format
     */

    static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Active', self::STATUS_INACTIVE => 'Inactive'
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

}
