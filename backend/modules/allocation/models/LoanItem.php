<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "loan_item".
 *
 * @property integer $loan_item_id
 * @property string $item_name
 * @property string $item_code
 * @property double $day_rate_amount
 * @property integer $is_active
 *
 * @property Allocation[] $allocations
 * @property AllocationSetting[] $allocationSettings
 * @property Disbursement[] $disbursements
 * @property DisbursementSetting[] $disbursementSettings
 * @property DisbursementSetting2[] $disbursementSetting2s
 * @property DisbursementSetting2[] $disbursementSetting2s0
 * @property InstitutionPaymentRequest[] $institutionPaymentRequests
 * @property InstitutionPaymentRequestDetail[] $institutionPaymentRequestDetails
 * @property ProgrammeFee[] $programmeFees
 */
class LoanItem extends \yii\db\ActiveRecord {
    /*
     * defines the constants for the rates
     */

    const RATE_DAILY = 1;
    const RATE_YEARLY = 2;
//constants for ststus
/// status constant value    
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /*
     * Loan Items Category  constants
     */
    const ITEM_CATEGORY_NORMAL = 'normal';
    const ITEM_CATEGORY_SCHOLARSHIP = 'scholarship';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'loan_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['item_name', 'item_code', 'is_active', 'rate_type', 'loan_item_category', 'study_level'], 'required'],
            //[['day_rate_amount'], 'number'],
            [['is_active','rate_type'], 'integer'],
            [['item_name', 'item_code'], 'unique'],
            [['item_name'], 'string', 'max' => 45],
            [['item_code'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'loan_item_id' => 'Loan Item ID',
            'item_name' => 'Item Name',
            'item_code' => 'Item Code',
            'is_active' => 'Status',
            'loan_item_category' => 'Item Category',
            'study_level' => 'Study Level',
            'rate_type' => 'Rate'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudyLevel() {
        return $this->hasOne(\backend\modules\application\models\ApplicantCategory::className(), ['applicant_category_id' => 'study_level']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocations() {
        return $this->hasMany(Allocation::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationSettings() {
        return $this->hasMany(AllocationSetting::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursements() {
        return $this->hasMany(Disbursement::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSettings() {
        return $this->hasMany(DisbursementSetting::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSetting2s() {
        return $this->hasMany(DisbursementSetting2::className(), ['associated_loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSetting2s0() {
        return $this->hasMany(DisbursementSetting2::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionPaymentRequests() {
        return $this->hasMany(InstitutionPaymentRequest::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionPaymentRequestDetails() {
        return $this->hasMany(InstitutionPaymentRequestDetail::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammeFees() {
        return $this->hasMany(ProgrammeFee::className(), ['loan_item_id' => 'loan_item_id']);
    }

    public static function getItemRates() {
        return [
            self::RATE_DAILY => 'Daily',
            self::RATE_YEARLY => 'Annual'
        ];
    }

    static function getItemRateByValue($Value) {
        $rates = self::getItemRates();
        if ($rates && isset($rates[$Value])) {
            return $rates[$Value];
        }
        return NULL;
    }

    static function getItemRateByItemId($Id) {
        if ($Id) {
            $loanItem = self::find()->where(['loan_item_id' => $Id])->one();

            if ($loanItem) {
                return $loanItem->rate_type;
            }
        }
        return NULL;
    }

    static function getLoanItemRateNameByItemId($ItemID) {
        $rates = self::getItemRates();
        $ItemRate = self::getItemRateByItemId($ItemID);
        if ($ItemRate && $rates & isset($rates[$ItemRate])) {
            return $rates[$ItemRate];
        }
        return NULL;
    }

    static function getLoanItemNameById($ItemID) {
        $Item = self::find()->where(['loan_item_id' => $ItemID])->one();
        if ($Item) {
            return $Item->item_name;
        }
        return NULL;
    }

    static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Active', self::STATUS_INACTIVE => 'Inactive'
        ];
    }

    public function getStatusNameByValue() {
        if ($this->is_active >= 0) {
            $statuses = self::getStatusList();
            if (isset($statuses[$this->is_active])) {
                return $statuses[$this->is_active];
            }
        }
        return NULL;
    }

    /*
     * rerutns loan items eligble for a particular programme
     */

    static function getLoanItemsByItem($Study_level = NULL, $loan_item_category = NULL) {
        $condition = [];
        if ($Study_level) {
            $condition['study_level'] = $Study_level;
        }
        if ($loan_item_category) {
            $condition['loan_item_category'] = $loan_item_category;
        }
        if ($loan_item_category OR $Study_level) {
            return self::find()->select('loan_item_id,item_name')->where($condition)->asArray()->all();
        }
        return self::find()->select('loan_item_id,item_name')->asArray()->all();
    }

    /*
     * returnds the list of Loan Items allowed for a given institution Programmes given institution ID
     */

    static function getLoanItemsByStatusCategoryStudyLevel($status = NULL, $loan_item_category, $study_level) {
        $condition = [
            'loan_item_category' => ':item_category',
            'study_level' => ':study_level'
        ];
        $attributes = [
            ':item_category' => $loan_item_category,
            ':study_level' => $study_level
        ];
        if (!is_null($status) && is_integer($status)) {
            $condition = [
                'is_active' => ':is_active',
            ];
            $attributes = [
                ':is_active' => $status
            ];
        }
        return new \yii\data\ActiveDataProvider([
            'query' => self::find()->where($conditselfion, $attributes)->all(),
            'pagination' => [
                'pagesize' => 10
            ]
        ]);
        
        
    }
    static function getStudentsType(){
            return [
               self::ITEM_CATEGORY_NORMAL => 'Normal',
               self::ITEM_CATEGORY_SCHOLARSHIP => 'Grant/scholarship',  
            ];
        }

}
