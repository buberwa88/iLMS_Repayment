<?php

namespace common\models;

use Yii;
use backend\modules\application\models\Application;
use backend\modules\application\models\Question;

/**
 * This is the model class for table "applicant_question".
 *
 * @property integer $applicant_question_id
 * @property integer $application_id
 * @property integer $question_id
 * @property integer $verification_status
 * @property string $comment
 *
 * @property ApplicantQnResponse[] $applicantQnResponses
 * @property Application $application
 * @property Question $question
 */
class ApplicantQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    const STATUS_VALID = 1;
    const STATUS_INVALID = 2;
    const STATUS_WAITING = 3;

    public static function tableName()
    {
        return 'applicant_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_id', 'question_id'], 'required'],
            [['application_id', 'question_id', 'verification_status'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'question_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_question_id' => 'Applicant Question ID',
            'application_id' => 'Application ID',
            'question_id' => 'Question ID',
            'verification_status' => 'Verification Status',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantQnResponses()
    {
        return $this->hasMany(ApplicantQnResponse::className(), ['applicant_question_id' => 'applicant_question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['question_id' => 'question_id']);
    }

    static function getVerificationStatus() {
        return array(
            self::STATUS_VALID => 'Valid',
            self::STATUS_INVALID => 'Invalid',
            self::STATUS_WAITING => 'Waiting'
        );
    }
}
