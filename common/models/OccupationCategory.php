<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "occupation_category".
 *
 * @property integer $occupation_category_id
 * @property string $category_desc
 *
 * @property Occupation[] $occupations
 */
class OccupationCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'occupation_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_desc'], 'required'],
            [['category_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'occupation_category_id' => 'Occupation Category ID',
            'category_desc' => 'Category Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccupations()
    {
        return $this->hasMany(Occupation::className(), ['occupation_category_id' => 'occupation_category_id']);
    }
}
