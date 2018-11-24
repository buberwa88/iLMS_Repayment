<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\ClusterProgramme as BaseClusterProgramme;

/**
 * This is the model class for table "cluster_programme".
 */
class ClusterProgramme extends BaseClusterProgramme {

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['academic_year_id', 'cluster_definition_id', 'programme_category_id', 'programme_group_id', 'programme_id','programme_priority'], 'required'],
            [['academic_year_id', 'cluster_definition_id', 'programme_category_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'programme_group_id', 'updated_at', 'programme_priority'], 'safe']
        ]);
    }

    static function getActivePendingProgramme() {
        
    }

}
