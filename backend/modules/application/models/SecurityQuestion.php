<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "security_question".
 *
 * @property integer $security_question_id
 * @property string $security_question
 *
 * @property User[] $users
 */
class SecurityQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'security_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['security_question'], 'required'],
            [['security_question'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'security_question_id' => 'Security Question ID',
            'security_question' => 'Security Question',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['security_question_id' => 'security_question_id']);
    }
}
