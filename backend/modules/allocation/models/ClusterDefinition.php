<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "cluster_definition".
 *
 * @property integer $cluster_definition_id
 * @property string $cluster_name
 * @property string $cluster_desc
 *
 * @property ClusterProgramme[] $clusterProgrammes
 */
class ClusterDefinition extends \yii\db\ActiveRecord {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cluster_definition';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cluster_name', 'cluster_desc', 'priority_order'], 'required'],
            [['priority_order'], 'unique', 'message' => 'Priority order has already been used'],
            [['cluster_name'], 'string', 'max' => 45],
            [['cluster_desc'], 'string', 'max' => 300],
            [['is_active'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'cluster_definition_id' => 'Cluster Definition',
            'cluster_name' => 'Cluster Name',
            'cluster_desc' => 'Description',
            'is_active' => 'Status',
            'priority_order' => 'Priority order'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusterProgrammes() {
        return $this->hasMany(ClusterProgramme::className(), ['cluster_definition_id' => 'cluster_definition_id']);
    }

    static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Active', self::STATUS_INACTIVE => 'Inactive'
        ];
    }

    public function getStatusName() {
        if ($this->is_active >= 0) {
            $statuses = self::getStatusList();
            if (isset($statuses[$this->is_active])) {
                return $statuses[$this->is_active];
            }
        }
        return NULL;
    }

}
