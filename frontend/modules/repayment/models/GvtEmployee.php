<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "gvt_employee".
 *
 * @property integer $gvt_employee
 * @property string $vote_number
 * @property string $vote_name
 * @property string $Sub_vote
 * @property string $sub_vote_name
 * @property string $check_number
 * @property string $f4indexno
 * @property string $first_name
 * @property string $middle_name
 * @property string $surname
 * @property string $sex
 * @property string $NIN
 * @property string $employment_date
 * @property string $created_at
 * @property string $payment_date
 */
class GvtEmployee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gvt_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employment_date', 'created_at', 'payment_date'], 'safe'],
            [['vote_number', 'Sub_vote', 'check_number'], 'string', 'max' => 50],
            [['vote_name', 'sub_vote_name', 'first_name', 'middle_name', 'surname', 'NIN'], 'string', 'max' => 100],
            [['f4indexno'], 'string', 'max' => 20],
            [['sex'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gvt_employee' => 'Gvt Employee',
            'vote_number' => 'Vote Number',
            'vote_name' => 'Vote Name',
            'Sub_vote' => 'Sub Vote',
            'sub_vote_name' => 'Sub Vote Name',
            'check_number' => 'Check Number',
            'f4indexno' => 'F4indexno',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'surname' => 'Surname',
            'sex' => 'Sex',
            'NIN' => 'Nin',
            'employment_date' => 'Employment Date',
            'created_at' => 'Created At',
            'payment_date' => 'Payment Date',
        ];
    }
}
