<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "ward".
 *
 * @property integer $ward_id
 * @property string $ward_name
 * @property integer $district_id
 *
 * @property LearningInstitution[] $learningInstitutions
 * @property District $district
 */
class Ward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ward_name', 'district_id'], 'required'],
            [['district_id'], 'integer'],
            [['ward_name'], 'string', 'max' => 45],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'district_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ward_id' => 'Ward ID',
            'ward_name' => 'Ward Name',
            'district_id' => 'District ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitutions()
    {
        return $this->hasMany(LearningInstitution::className(), ['ward_id' => 'ward_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(\common\models\District::className(), ['district_id' => 'district_id']);
    }
}
