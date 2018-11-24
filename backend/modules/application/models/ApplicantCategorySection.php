<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "applicant_category_section".
 *
 * @property integer $applicant_category_section_id
 * @property integer $applicant_category_id
 * @property integer $section_id
 * @property integer $display_order
 *
 * @property Section $section
 * @property ApplicantCategory $applicantCategory
 * @property SectionQuestion[] $sectionQuestions
 */
class ApplicantCategorySection extends \yii\db\ActiveRecord
{
    public $category;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applicant_category_section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applicant_category_id', 'section_id'], 'required'],
            [['applicant_category_id', 'section_id', 'display_order'], 'integer'],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'section_id']],
            [['applicant_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicantCategory::className(), 'targetAttribute' => ['applicant_category_id' => 'applicant_category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_category_section_id' => 'Applicant Category',
            'applicant_category_id' => 'Applicant Category ID',
            'section_id' => 'Section ID',
            'display_order' => 'Display Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['section_id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCategory()
    {
        return $this->hasOne(ApplicantCategory::className(), ['applicant_category_id' => 'applicant_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionQuestions()
    {
        return $this->hasMany(SectionQuestion::className(), ['applicant_category_section_id' => 'applicant_category_section_id']);
    }
}
