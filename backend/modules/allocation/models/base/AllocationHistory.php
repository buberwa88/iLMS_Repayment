<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "allocation_history".
 *
 * @property integer $loan_allocation_history_id
 * @property integer $academic_year_id
 * @property integer $study_level
 * @property integer $place_of_study
 * @property integer $allocation_framework_id
 * @property integer $student_type
 * @property string $created_at
 * @property integer $created_by
 * @property string $reviewed_at
 * @property integer $reviewed_by
 * @property string $approved_at
 * @property integer $approved_by
 * @property integer $status
 *
 * @property \backend\modules\allocation\models\AcademicYear $academicYear
 * @property \backend\modules\allocation\models\AllocationPlan $allocationFramework
 * @property \backend\modules\allocation\models\AllocationPlanStudent[] $allocationPlanStudents
 */
class AllocationHistory extends \yii\db\ActiveRecord {

///costants for country of study
    const PLACE_TZ = 'TZ';
    const PLACE_FCOUNTRY = 'FCOUNTRY';
//    constants for student types
    const STUDENT_TYPE_NORMAL = 'normal';
    const STUDENT_TYPE_GRANT = 'scholarship';

    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

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
            'allocationFramework',
            'allocationPlanStudents'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['academic_year_id', 'allocation_name', 'description', 'place_of_study', 'student_type', 'study_level'], 'required'],
            [['allocation_framework_id'], 'required', 'on' => 'local-freshers'],
            [['allocation_name'], 'unique'],
            [['academic_year_id', 'study_level', 'allocation_framework_id', 'created_by', 'reviewed_by', 'approved_by', 'status'], 'integer'],
            [['created_at', 'reviewed_at', 'approved_at'], 'safe']
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'allocation_history';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'loan_allocation_history_id' => 'Loan Allocation',
            'academic_year_id' => 'Academic Year',
            'description' => 'Allocation Description',
            'study_level' => 'Level of Study',
            'place_of_study' => 'Place Of Study',
            'allocation_framework_id' => 'Allocation Framework',
            'student_type' => 'Student Type',
            'reviewed_at' => 'Reviewed At',
            'reviewed_by' => 'Reviewed By',
            'approved_at' => 'Approved At',
            'approved_by' => 'Approved By',
            'status' => 'Status',
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
    public function getAllocationFramework() {
        return $this->hasOne(\backend\modules\allocation\models\AllocationPlan::className(), ['allocation_plan_id' => 'allocation_framework_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanStudents() {
        return $this->hasMany(\backend\modules\allocation\models\AllocationPlanStudent::className(), ['allocation_history_id' => 'loan_allocation_history_id']);
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
                'updatedAtAttribute' => 'reviewed_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'reviewed_by',
                'value' => \Yii::$app->user->identity->user_id,
            ],
        ];
    }

    function getPlaceofStudy() {
        if ($this->place_of_study) {
            switch ($this->place_of_study) {
                case self::PLACE_TZ:
                    return 'Tanzania';
                    break;
                case self::PLACE_FCOUNTRY:
                    return 'Foreign Country';
                    break;
            }
        }
    }

    function getStudentTypeName() {
        if ($this->student_type) {
            switch ($this->student_type) {
                case self::STUDENT_TYPE_NORMAL:
                    return 'Normal';
                    break;
                case self::STUDENT_TYPE_GRANT:
                    return 'Grant/Scholarship';
                    break;
            }
        }
    }

}
