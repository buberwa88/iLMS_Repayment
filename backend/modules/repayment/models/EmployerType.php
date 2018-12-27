<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "employer_type".
 *
 * @property integer $employer_type_id
 * @property string $name
 * @property string $created_at
 * @property integer $created_by
 * @property integer $is_active
 */
class EmployerType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employer_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_type', 'created_at','has_TIN','employer_group_id'], 'required'],
            [['created_at'], 'safe'],
            [['is_active'], 'integer'],
            [['employer_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employer_type_id' => 'Employer Type ID',
            'employer_type' => 'Employer Type',
            'created_at' => 'Created At',
            'is_active' => 'Is Active',
			'has_TIN'=>'Has TIN?',
			'employer_group_id'=>'Employer Group',
        ];
    }
	public function getEmployerGroup()
    {
        return $this->hasOne(EmployerGroup::className(), ['employer_group_id' => 'employer_group_id']);
    }
}
