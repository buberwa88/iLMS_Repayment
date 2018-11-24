<?php

namespace frontend\modules\application\models;

use Yii;

/**
 * This is the model class for table "occupation".
 *
 * @property integer $occupation_id
 * @property integer $occupation_category_id
 * @property string $occupation_desc
 *
 * @property Guarantor[] $guarantors
 * @property OccupationCategory $occupationCategory
 */
class Occupation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'occupation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['occupation_category_id', 'occupation_desc'], 'required'],
            [['occupation_category_id'], 'integer'],
            [['occupation_desc'], 'string', 'max' => 45],
            [['occupation_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => OccupationCategory::className(), 'targetAttribute' => ['occupation_category_id' => 'occupation_category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'occupation_id' => 'Occupation ID',
            'occupation_category_id' => 'Occupation Category ID',
            'occupation_desc' => 'Occupation Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuarantors()
    {
        return $this->hasMany(Guarantor::className(), ['occupation_id' => 'occupation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccupationCategory()
    {
        return $this->hasOne(OccupationCategory::className(), ['occupation_category_id' => 'occupation_category_id']);
    }
}
