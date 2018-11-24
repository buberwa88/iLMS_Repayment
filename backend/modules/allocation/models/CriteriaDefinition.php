<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "criteria_definition".
 *
 * @property integer $criteria_id
 * @property string $criteria_description
 * @property integer $is_active
 */
class CriteriaDefinition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'criteria_definition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['criteria_description'], 'required'],
            [['is_active'], 'integer'],
            [['criteria_description'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'criteria_id' => 'Criteria ID',
            'criteria_description' => 'Criteria Description',
            'is_active' => 'Is Active',
        ];
    }
}
