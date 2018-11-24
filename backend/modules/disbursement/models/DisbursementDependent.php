<?php

namespace backend\modules\disbursement\models;

use Yii;

/**
 * This is the model class for table "disbursement_setting2".
 *
 * @property integer $disbursement_setting2_id
 * @property integer $academic_year_id
 * @property integer $instalment_definition_id
 * @property integer $loan_item_id
 * @property integer $associated_loan_item_id
 *
 * @property AcademicYear $academicYear
 * @property LoanItem $associatedLoanItem
 * @property InstalmentDefinition $instalmentDefinition
 * @property LoanItem $loanItem
 */
class DisbursementDependent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disbursement_setting2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_year_id', 'instalment_definition_id', 'loan_item_id', 'associated_loan_item_id'], 'required'],
            [['academic_year_id', 'instalment_definition_id', 'loan_item_id', 'associated_loan_item_id'], 'integer'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' =>  \common\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['associated_loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\LoanItem::className(), 'targetAttribute' => ['associated_loan_item_id' => 'loan_item_id']],
            [['instalment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstalmentDefinition::className(), 'targetAttribute' => ['instalment_definition_id' => 'instalment_definition_id']],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\LoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'disbursement_setting2_id' => 'Disbursement Setting',
            'academic_year_id' => 'Academic Year ',
            'instalment_definition_id' => 'Instalment',
            'loan_item_id' => 'Loan Item',
            'associated_loan_item_id' => 'Associated Loan Item',
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
    public function getAssociatedLoanItem()
    {
        return $this->hasOne(\backend\modules\allocation\models\LoanItem::className(), ['loan_item_id' => 'associated_loan_item_id']);
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
   public static function getLoanItemdata($loanItemId) {
            $data2 = \backend\modules\allocation\models\LoanItem::findBySql(" SELECT loan_item_id AS id, item_name AS name FROM loan_item WHERE loan_item_id<>'$loanItemId'")->asArray()->all();
            $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
            return $value2;
        
    }
}
