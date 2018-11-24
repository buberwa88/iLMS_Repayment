<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "source_table".
 *
 * @property integer $source_table_id
 * @property string $source_table_name
 * @property string $source_table_id_field
 * @property string $source_table_text_field
 * @property integer $usage_in
 */
class SourceTable extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'source_table';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['source_table_name', 'usage_in'], 'required'],
            [['usage_in'], 'integer'],
            [['source_table_name', 'source_table_id_field', 'source_table_text_field'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'source_table_id' => 'Source Table ID',
            'source_table_name' => 'Source Table Name',
            'source_table_id_field' => 'Source Table Id Field',
            'source_table_text_field' => 'Source Table Text Field',
            'usage_in' => 'Usage In',
        ];
    }

   static function getNamebyId($Id) {
        $data = self::find()->where(['source_table_id' => $Id])->one();
        if ($data) {
            return $data->source_table_name;
        }
        return NULL;
    }

}
