<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "scholarship_loan_item".
 *
 * @property integer $scholarship_definition_id
 * @property integer $loan_item_id
 * @property integer $is_active
 * @property integer $is_loan_item
 *
 * @property LoanItem $loanItem
 * @property ScholarshipDefinition $scholarshipDefinition
 */
class ScholarshipLoanItem extends \yii\db\ActiveRecord {

    const SCHOLARSHIP_ITEM_LOAN_ITEM = 1;
    const SCHOLARSIP_ITEM_NON_LOAN_ITEM = 0;
    ///status
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'scholarship_loan_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['scholarship_definition_id', 'loan_item_id'], 'required'],
            [['scholarship_definition_id', 'loan_item_id', 'is_active', 'is_loan_item'], 'integer'],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
            [['scholarship_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScholarshipDefinition::className(), 'targetAttribute' => ['scholarship_definition_id' => 'scholarship_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'scholarship_definition_id' => 'Scholarship Definition ID',
            'loan_item_id' => 'Loan Item ID',
            'is_active' => 'Status',
            'is_loan_item' => 'Is Loanable Item',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem() {
        return $this->hasOne(LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScholarshipDefinition() {
        return $this->hasOne(ScholarshipDefinition::className(), ['scholarship_id' => 'scholarship_definition_id']);
    }

    static function getLoanItemsById($id) {
        return new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\allocation\models\ScholarshipLoanItem::find()->where(['scholarship_definition_id' => $id]),
        ]);
    }

    static function getScholarshipLoanItemTypesOptions() {
        return [
            self::SCHOLARSHIP_ITEM_LOAN_ITEM => 'Yes',
            self::SCHOLARSIP_ITEM_NON_LOAN_ITEM => 'No'
        ];
    }

    function getScholarShipIteTypeName() {
        $itemTypes = self::getScholarshipLoanItemTypesOptions();
        if (isset($itemTypes[$this->is_loan_item])) {
            return $itemTypes[$this->is_loan_item];
        }
        return NULL;
    }

    static function getScholarshipStatusOptions() {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive'
        ];
    }

    function getScholarShipStatusName() {
        $statuses = self::getScholarshipStatusOptions();
        if (isset($statuses[$this->is_active])) {
            return $statuses[$this->is_active];
        }
        return NULL;
    }

}
