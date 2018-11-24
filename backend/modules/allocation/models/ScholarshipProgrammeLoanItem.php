<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "scholarship_programme_loan_item".
 *
 * @property string $created_at
 * @property integer $academic_year_id
 * @property integer $scholarships_id
 * @property integer $programme_id
 * @property integer $loan_item_id
 * @property integer $rate_type
 * @property double $unit_amount
 * @property integer $duration
 *
 * @property LoanItem $loanItem
 * @property AcademicYear $academicYear
 * @property ScholarshipProgramme $scholarships
 */
class ScholarshipProgrammeLoanItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scholarship_programme_loan_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['academic_year_id', 'scholarships_id', 'programme_id', 'loan_item_id', 'rate_type', 'unit_amount', 'duration'], 'required'],
            [['academic_year_id', 'scholarships_id', 'programme_id', 'loan_item_id', 'rate_type', 'duration'], 'integer'],
            [['unit_amount'], 'number'],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['scholarships_id', 'programme_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScholarshipProgramme::className(), 'targetAttribute' => ['scholarships_id' => 'scholarship_id', 'programme_id' => 'programme_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created_at' => 'Created At',
            'academic_year_id' => 'Academic Year ID',
            'scholarships_id' => 'Scholarships ID',
            'programme_id' => 'Programme ID',
            'loan_item_id' => 'Loan Item ID',
            'rate_type' => 'Rate Type',
            'unit_amount' => 'Unit Amount',
            'duration' => 'Duration',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem()
    {
        return $this->hasOne(LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScholarships()
    {
        return $this->hasOne(ScholarshipProgramme::className(), ['scholarship_id' => 'scholarships_id', 'programme_id' => 'programme_id']);
    }
}
