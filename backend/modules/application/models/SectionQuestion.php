<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "section_question".
 *
 * @property integer $section_question_id
 * @property integer $applicant_category_section_id
 * @property integer $question_id
 * @property integer $attachment_definition_id
 *
 * @property ApplicantCategorySection $applicantCategorySection
 * @property AttachmentDefinition $attachmentDefinition
 * @property Question $question
 */
class SectionQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applicant_category_section_id'], 'required'],
            [['applicant_category_section_id', 'question_id'], 'integer'],
            [['applicant_category_section_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicantCategorySection::className(), 'targetAttribute' => ['applicant_category_section_id' => 'applicant_category_section_id']],
            
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'question_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'section_question_id' => 'Section Question ID',
            'applicant_category_section_id' => 'Applicant Category',
            'question_id' => 'Question ID',
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCategorySection()
    {
        return $this->hasOne(ApplicantCategorySection::className(), ['applicant_category_section_id' => 'applicant_category_section_id']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['question_id' => 'question_id']);
    }
}
