<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "semester".
 *
 * @property integer $semester_id
 * @property integer $semester_number
 * @property string $description
 * @property integer $is_active
 */
class Semester extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semester';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['semester_number', 'description'], 'required'],
            [['semester_number', 'is_active'], 'integer'],
            [['description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'semester_id' => 'Semester ID',
            'semester_number' => 'Semester Number',
            'description' => 'Description',
            'is_active' => 'Is Active',
        ];
    }
}
