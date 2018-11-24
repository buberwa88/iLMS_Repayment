<?php

namespace backend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "appeal_category".
 *
 * @property integer $appeal_category_id
 * @property string $name
 */
class AppealCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appeal_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'appeal_category_id' => 'Appeal Category ID',
            'name' => 'Name',
        ];
    }
}
