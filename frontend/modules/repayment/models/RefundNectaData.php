<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_necta_data".
 *
 * @property integer $refund_necta_data
 * @property string $registration_number
 * @property integer $completion_year
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $created_at
 * @property integer $created_by
 */
class RefundNectaData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_necta_data';
    }

    /**
     * @inheritdoc
     */
    public $validated;
    public function rules()
    {
        return [
            [['completion_year', 'created_by'], 'integer'],
            [['created_at','szExamCentreName','validated'], 'safe'],
            [['registration_number', 'firstname', 'middlename', 'lastname'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_necta_data' => 'Refund Necta Data',
            'registration_number' => 'Registration Number',
            'completion_year' => 'Completion Year',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'lastname' => 'Lastname',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'szExamCentreName'=>'School Name',
            'validated'=>'validated',
        ];
    }
    public static function getNectaDataDetails($registration_number,$completion_year){
        $details_ = self::find()
            ->where(['registration_number'=>$registration_number,'completion_year'=>$completion_year])
            ->one();
        return $details_;
    }
}
