<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "cluster_programme".
 *
 * @property integer $cluster_programme_id
 * @property integer $academic_year_id
 * @property integer $cluster_definition_id
 * @property integer $sub_cluster_definition_id
 * @property integer $programme_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\allocation\models\AcademicYear $academicYear
 * @property \backend\modules\allocation\models\ClusterDefinition $clusterDefinition
 * @property \backend\modules\allocation\models\Programme $programme
 * @property \backend\modules\allocation\models\SubClusterDefinition $subClusterDefinition
 * @property \backend\modules\allocation\models\User $createdBy
 * @property \backend\modules\allocation\models\User $updatedBy
 */
class ClusterProgramme extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;
    private $institution;

    public function __construct() {
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => 1,
            'deleted_at' => 1,
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames() {
        return [
            'academicYear',
            'clusterDefinition',
            'programme',
            'subClusterDefinition',
            'createdBy',
            'updatedBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['academic_year_id', 'cluster_definition_id', 'programme_category_id', 'programme_id', 'programme_group_id', 'programme_id'], 'required'],
            [['academic_year_id', 'cluster_definition_id', 'programme_category_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'programme_id', 'updated_at', 'programme_priority'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cluster_programme';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'cluster_programme_id' => 'Cluster Programme',
            'academic_year_id' => 'Academic Year',
            'cluster_definition_id' => 'Cluster Definition ',
            'programme_category_id' => 'Programme Category',
            'programme_group_id' => 'Programme Group',
            'programme_id' => 'Programme Name',
            'is_active' => 'Status',
            'institution'=>'Institution'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(\backend\modules\allocation\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusterDefinition() {
        return $this->hasOne(\backend\modules\allocation\models\ClusterDefinition::className(), ['cluster_definition_id' => 'cluster_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramme() {
        return $this->hasOne(\backend\modules\allocation\models\Programme::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammeCategory() {
        return $this->hasOne(\backend\modules\allocation\models\ProgrammeCategory::className(), ['programme_category_id' => 'programme_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammeGroup() {
        return $this->hasOne(\backend\modules\allocation\models\ProgrammeGroup::className(), ['programme_group_id' => 'programme_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(\backend\modules\allocation\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(\backend\modules\allocation\models\User::className(), ['user_id' => 'updated_by']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => \Yii::$app->user->identity->user_id,
            ],
        ];
    }

}
