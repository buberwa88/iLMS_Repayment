<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_education_history".
 *
 * @property integer $refund_education_history_id
 * @property integer $refund_application_id
 * @property integer $program_id
 * @property integer $institution_id
 * @property integer $entry_year
 * @property integer $completion_year
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property User $createdBy
 * @property LearningInstitution $institution
 * @property Programme $program
 * @property User $updatedBy
 */
class RefundEducationHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_education_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_application_id', 'program_id', 'institution_id', 'entry_year', 'completion_year', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\LearningInstitution::className(), 'targetAttribute' => ['institution_id' => 'learning_institution_id']],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\Programme::className(), 'targetAttribute' => ['program_id' => 'programme_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_education_history_id' => 'Refund Education History ID',
            'refund_application_id' => 'Refund Application ID',
            'program_id' => 'Program ID',
            'institution_id' => 'Institution ID',
            'entry_year' => 'Entry Year',
            'completion_year' => 'Completion Year',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitution()
    {
        return $this->hasOne(\backend\modules\allocation\models\LearningInstitution::className(), ['learning_institution_id' => 'institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(\backend\modules\allocation\models\Programme::className(), ['programme_id' => 'program_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }
}
