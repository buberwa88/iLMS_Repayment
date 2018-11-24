<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_plan_cluster_setting".
 *
 * @property integer $allocation_plan_cluster_setting_id
 * @property integer $allocation_plan_id
 * @property integer $cluster_definition_id
 * @property integer $cluster_priority
 * @property double $student_percentage_distribution
 * @property double $budget_percentage_distribution
 *
 * @property AllocationPlan $allocationPlan
 * @property ClusterDefinition $clusterDefinition
 */
class AllocationPlanClusterSetting extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'allocation_plan_cluster_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['allocation_plan_id', 'cluster_definition_id', 'cluster_priority'], 'required'],
            [['allocation_plan_id', 'cluster_definition_id', 'cluster_priority'], 'integer'],
            [['cluster_definition_id'], 'validateCluster'],
            [['cluster_priority'], 'validateClusterPriority'],
            [['student_percentage_distribution'], 'validateStudentComposition'],
            [['student_percentage_distribution', 'budget_percentage_distribution'], 'number'],
            [['allocation_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationPlan::className(), 'targetAttribute' => ['allocation_plan_id' => 'allocation_plan_id']],
            [['cluster_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClusterDefinition::className(), 'targetAttribute' => ['cluster_definition_id' => 'cluster_definition_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'allocation_plan_cluster_setting_id' => 'Allocation Plan Cluster Setting ID',
            'allocation_plan_id' => 'Allocation Plan ID',
            'cluster_definition_id' => 'Cluster Definition ID',
            'cluster_priority' => 'Cluster Priority',
            'student_percentage_distribution' => 'Student % Distribution',
            'budget_percentage_distribution' => 'Budget % Distribution',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlan() {
        return $this->hasOne(AllocationPlan::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusterDefinition() {
        return $this->hasOne(ClusterDefinition::className(), ['cluster_definition_id' => 'cluster_definition_id']);
    }

    static function getAllocationPlanClustersById($id) {
        return new \yii\data\ActiveDataProvider([
            'query' => self::find()->where(['allocation_plan_id' => $id]),
        ]);
    }

    public function validateCluster($attribute) {
        if ($this->allocation_plan_id && $attribute) {
            if (self::find()->where(['allocation_plan_id' => $this->allocation_plan_id, 'cluster_definition_id' => $this->cluster_definition_id])->exists()) {
                $this->addError($attribute, 'Selected CLuster exist in this allocation Plan');
                return FALSE;
            }
        }
        return TRUE;
    }

    public function validateClusterPriority($attribute) {
        if ($this->allocation_plan_id && $attribute) {
            if (self::find()->where(['allocation_plan_id' => $this->allocation_plan_id, 'cluster_priority' => $this->cluster_priority])->exists()) {
                $this->addError($attribute, 'Selected Cluster Priority already in use by other cluster in this Allocation Plan');
                return FALSE;
            }
        }
        return TRUE;
    }

    public function validateStudentComposition($attribute) {
        if ($this->allocation_plan_id && $attribute) {
            $data = self::find()->select('SUM(student_percentage_distribution) AS student_percentage_distribution')->where(['allocation_plan_id' => $this->allocation_plan_id])->one();
            $total = $data->student_percentage_distribution + $this->student_percentage_distribution;

            if ($total > 100) {
                $this->addError($attribute, '% Distribution entered is greater than the allowed value, Total % Distribution for all clusters should not exceed 100');
                return FALSE;
            }
        }
        return TRUE;
    }
    
    static function getClusterSettingsByAlloationPlanID($id) {
        return self::find()->where('allocation_plan_id=:id', [':id' => $id])->orderBy('cluster_priority ASC')->all();
    }

}
