<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "applicant_category".
 *
 * @property integer $applicant_category_id
 * @property string $applicant_category
 *
 * @property ApplicantCategoryAttachment[] $applicantCategoryAttachments
 * @property ApplicantCategorySection[] $applicantCategorySections
 * @property Application[] $applications
 * @property CriteriaField[] $criteriaFields
 */
class ApplicantCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applicant_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applicant_category'], 'required'],
            [['applicant_category'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_category_id' => 'Applicant Category ID',
            'applicant_category' => 'Applicant Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCategoryAttachments()
    {
        return $this->hasMany(ApplicantCategoryAttachment::className(), ['applicant_category_id' => 'applicant_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCategorySections()
    {
        return $this->hasMany(ApplicantCategorySection::className(), ['applicant_category_id' => 'applicant_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['applicant_category_id' => 'applicant_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaFields()
    {
        return $this->hasMany(CriteriaField::className(), ['applicant_category_id' => 'applicant_category_id']);
    }
}
