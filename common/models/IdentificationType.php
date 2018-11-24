<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "identification_type".
 *
 * @property integer $identification_type_id
 * @property string $identification_type
 * @property integer $status
 *
 * @property Applicant[] $applicants
 */
class IdentificationType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'identification_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identification_type'], 'required'],
            [['status'], 'integer'],
            [['identification_type'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'identification_type_id' => 'Identification Type ID',
            'identification_type' => 'Identification Type',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicants()
    {
        return $this->hasMany(Applicant::className(), ['identification_type_id' => 'identification_type_id']);
    }
}
