<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "temp_upload".
 *
 * @property integer $id
 * @property string $file
 */
class Tempupload extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'temp_upload';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
        ];
    }
}
