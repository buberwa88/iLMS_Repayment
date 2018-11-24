<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "qtrigger".
 *
 * @property integer $qtrigger_id
 * @property integer $qtrigger_main_id
 * @property integer $qpossible_response_id
 */
class Qtrigger extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtrigger';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qtrigger_main_id', 'qpossible_response_id'], 'required'],
            [['qtrigger_main_id', 'qpossible_response_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qtrigger_id' => 'Qtrigger ID',
            'qtrigger_main_id' => 'Qtrigger Main ID',
            'qpossible_response_id' => 'Qpossible Response ID',
        ];
    }
}
