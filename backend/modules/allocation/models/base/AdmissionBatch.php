<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "admission_batch".
 *
 * @property integer $admission_batch_id
 * @property integer $academic_year_id
 * @property string $batch_number
 * @property string $batch_desc
 * @property string $created_at
 * @property integer $created_by
 *
 * @property \backend\modules\allocation\models\AcademicYear $academicYear
 * @property \backend\modules\allocation\models\User $createdBy
 * @property \backend\modules\allocation\models\AdmittedStudent[] $admittedStudents
 */
class AdmissionBatch extends \yii\db\ActiveRecord {

    const DUMP_TYPE_FILE = 0;
    const DUMP_TYPE_API = 1;

    use \mootensai\relation\RelationTrait;

    public function __construct() {
        
    }

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames() {
        return [
            'academicYear',
            'createdBy',
            'admittedStudents'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['academic_year_id', 'batch_number', 'batch_desc', 'dump_type'], 'required'],
            [['academic_year_id', 'created_by'], 'integer'],
            [['batch_number'], 'unique'],
            [['created_at'], 'safe'],
            [['batch_number'], 'string', 'max' => 10],
            [['batch_desc'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'admission_batch';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'admission_batch_id' => 'Admission Batch',
            'academic_year_id' => 'Academic Year',
            'batch_number' => 'Batch Number',
            'batch_desc' => 'Batch Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmittedStudents() {
        return $this->hasMany(\backend\modules\allocation\models\AdmittedStudent::className(), ['admission_batch_id' => 'admission_batch_id']);
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
//                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
//                'updatedByAttribute' => 'updated_by',
                'value' => \Yii::$app->user->identity->user_id,
            ],
        ];
    }

}
