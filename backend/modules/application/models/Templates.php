<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "templates".
 *
 * @property integer $template_id
 * @property string $template_name
 * @property string $template_content
 * @property integer $template_status
 */
class Templates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'templates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['template_id'], 'required'],
            [['template_id', 'template_status'], 'integer'],
            [['template_content'], 'string'],
            [['template_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'template_id' => 'Template ID',
            'template_name' => 'Template Name',
            'template_content' => 'Template Content',
            'template_status' => 'Template Status',
        ];
    }
}
