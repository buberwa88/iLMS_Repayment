<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property integer $content_id
 * @property string $title
 * @property string $description
 * @property integer $academic_year_id
 * @property integer $status
 *
 * @property AcademicYear $academicYear
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'academic_year_id', 'status'], 'required'],
            [['description'], 'string'],
            [['academic_year_id', 'status'], 'integer'],
            [['title'], 'string', 'max' => 300],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content_id' => 'Content ID',
            'title' => 'Title',
            'description' => 'Description',
            'academic_year_id' => 'Academic Year ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }
}
