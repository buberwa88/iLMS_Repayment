<?php

namespace backend\modules\report\models;

use Yii;

/**
 * This is the model class for table "erp_report_category".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $category
 */
class ReportCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['category'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'category' => 'Category',
        ];
    }
}
