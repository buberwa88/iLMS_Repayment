<?php

namespace backend\modules\disbursement\models;

use Yii;

/**
 * This is the model class for table "disbursement_setting".
 *
 * @property integer $disbursement_setting_id
 * @property integer $academic_year_id
 * @property integer $instalment_definition_id
 * @property integer $loan_item_id
 * @property double $percentage
 *
 * @property AcademicYear $academicYear
 * @property InstalmentDefinition $instalmentDefinition
 * @property LoanItem $loanItem
 */
class DisbursementSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disbursement_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_year_id', 'instalment_definition_id', 'loan_item_id', 'percentage'], 'required'],
            [['academic_year_id', 'instalment_definition_id', 'loan_item_id'], 'integer'],
            [['percentage'], 'number'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['instalment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstalmentDefinition::className(), 'targetAttribute' => ['instalment_definition_id' => 'instalment_definition_id']],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' =>\backend\modules\allocation\models\LoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'disbursement_setting_id' => 'Disbursement Setting ',
            'academic_year_id' => 'Academic Year ',
            'instalment_definition_id' => 'Instalment',
            'loan_item_id' => 'Loan Item ',
            'percentage' => 'Value(%)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstalmentDefinition()
    {
        return $this->hasOne(InstalmentDefinition::className(), ['instalment_definition_id' => 'instalment_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem()
    {
        return $this->hasOne(\backend\modules\allocation\models\LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }
}
