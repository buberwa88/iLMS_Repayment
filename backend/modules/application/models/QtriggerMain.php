<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "qtrigger_main".
 *
 * @property integer $qtrigger_main_id
 * @property string $description
 * @property string $join_operator
 */
class QtriggerMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtrigger_main';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['join_operator'], 'string'],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qtrigger_main_id' => 'Qtrigger Main ID',
            'description' => 'Description',
            'join_operator' => 'Join Operator',
        ];
    }
}
