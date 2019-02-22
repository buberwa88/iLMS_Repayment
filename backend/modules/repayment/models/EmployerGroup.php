<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "employer_group".
 *
 * @property integer $employer_group_id
 * @property string $group_name
 * @property string $created_at
 * @property integer $created_by
 */
class EmployerGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employer_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'required'],
            [['created_at'], 'safe'],
            [['created_by'], 'integer'],
            [['group_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employer_group_id' => 'Employer Group ID',
            'group_name' => 'Group Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
