<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "bank".
 *
 * @property integer $bank_id
 * @property string $bank_name
 * @property string $swift_code
 *
 * @property Application[] $applications
 * @property BankAccount[] $bankAccounts
 * @property LearningInstitution[] $learningInstitutions
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_name'], 'required'],
            [['bank_name'], 'string', 'max' => 45],
            [['swift_code'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bank_id' => 'Bank ID',
            'bank_name' => 'Bank Name',
            'swift_code' => 'Swift Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['bank_id' => 'bank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankAccounts()
    {
        return $this->hasMany(BankAccount::className(), ['bank_id' => 'bank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitutions()
    {
        return $this->hasMany(LearningInstitution::className(), ['bank_id' => 'bank_id']);
    }
}
