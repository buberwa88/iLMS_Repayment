<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "qns_to_trigger".
 *
 * @property integer $qns_to_trigger_id
 * @property integer $qtrigger_main_id
 * @property integer $question_id
 */
class QnsToTrigger extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qns_to_trigger';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qtrigger_main_id', 'question_id'], 'required'],
            [['qtrigger_main_id', 'question_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qns_to_trigger_id' => 'Qns To Trigger ID',
            'qtrigger_main_id' => 'Qtrigger Main ID',
            'question_id' => 'Question ID',
        ];
    }
}
