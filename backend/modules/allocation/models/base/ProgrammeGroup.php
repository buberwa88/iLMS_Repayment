<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "programme_group".
 *
 * @property integer $programme_group_id
 * @property string $group_code
 * @property string $group_name
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\allocation\models\Programme[] $programmes
 * @property \backend\modules\allocation\models\User $createdBy
 * @property \backend\modules\allocation\models\User $updatedBy
 */
class ProgrammeGroup extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    public function __construct() {
        parent::__construct();
    }

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames() {
        return [
            'programmes',
            'createdBy',
            'updatedBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['group_code', 'group_name', 'study_level', 'programme_group_desc'], 'required'],
            [['group_code', 'group_name'], 'unique', 'message' => '{attribute} already exist in the system'],
            [['created_at', 'updated_at', 'created_at', 'created_by'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['group_code'], 'string', 'max' => 20],
            ['group_name', 'string', 'min' => 2, 'max' => 150, 'message' => '{attribute} should be at least 2 symbols'],
           // [['group_name'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'programme_group';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'programme_group_id' => 'Programme Group',
            'group_code' => 'Group Code',
            'group_name' => 'Group Name',
            'study_level' => 'Programme Level',
            'programme_group_desc' => 'Group Description'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammes() {
        return $this->hasMany(\backend\modules\allocation\models\Programme::className(), ['programme_group_id' => 'programme_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusterProgrammes() {
        return $this->hasMany(\backend\modules\allocation\models\ClusterProgramme::className(), ['programme_group_id' => 'programme_group_id']);
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
    public function getUpdatedBy() {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'updated_by']);
    }

    public function getApplicantCategory() {
        return $this->hasOne(\backend\modules\application\models\ApplicantCategory::className(), ['applicant_category_id' => 'study_level']);
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
