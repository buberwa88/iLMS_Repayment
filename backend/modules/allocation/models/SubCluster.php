<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "sub_cluster_definition".
 *
 * @property integer $sub_cluster_definition_id
 * @property string $sub_cluster_name
 * @property string $sub_cluster_desc
 *
 * @property ClusterProgramme[] $clusterProgrammes
 */
class SubCluster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_cluster_definition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sub_cluster_name'], 'required'],
            [['sub_cluster_name'], 'string', 'max' => 45],
            [['sub_cluster_desc'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sub_cluster_definition_id' => 'Sub Cluster Definition ID',
            'sub_cluster_name' => 'Sub Cluster Name',
            'sub_cluster_desc' => 'Sub Cluster Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusterProgrammes()
    {
        return $this->hasMany(ClusterProgramme::className(), ['sub_cluster_definition_id' => 'sub_cluster_definition_id']);
    }
}
