<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "nature_of_work".
 *
 * @property integer $nature_of_work_id
 * @property string $description
 */
class NatureOfWork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nature_of_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'unique', 'message'=>'Sector exist!'],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nature_of_work_id' => 'Nature Of Work ID',
            'description' => 'Description',
        ];
    }
}
