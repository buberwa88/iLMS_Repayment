<?php

namespace backend\modules\repayment\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "refund_letter_format".
 *
 * @property integer $refund_letter_format_id
 * @property string $letter_name
 * @property string $header
 * @property string $footer
 * @property string $letter_heading
 * @property string $letter_body
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property \backend\modules\repayment\models\RefundApplicationOperationLetter[] $refundApplicationOperationLetters
 * @property \backend\modules\repayment\models\User $createdBy
 * @property \backend\modules\repayment\models\User $updatedBy
 */
class RefundLetterFormat extends \yii\db\ActiveRecord {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    use \mootensai\relation\RelationTrait;

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames() {
        return [
            'refundApplicationOperationLetters',
            'createdBy',
            'updatedBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['letter_name', 'letter_reference_no', 'header', 'footer', 'letter_heading', 'letter_body', 'created_by'], 'required'],
            [['letter_body'], 'string'],
            [['letter_name', 'letter_heading', 'letter_body'], 'unique'],
            [['letter_name', 'letter_reference_no', 'letter_heading'], 'string', 'max' => 200],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_active'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'refund_letter_format';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'refund_letter_format_id' => 'Letter Format ID',
            'letter_name' => 'Name',
            'letter_reference_no' => 'Reference No',
            'header' => 'Letter Header',
            'footer' => 'Letter Footer',
            'letter_heading' => 'Letter Subject',
            'letter_body' => 'Letter Body',
            'is_active' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationOperationLetters() {
        return $this->hasMany(\backend\modules\repayment\models\RefundApplicationOperationLetter::className(), ['refund_letter_format_id' => 'refund_letter_format_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(\backend\modules\repayment\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(\backend\modules\repayment\models\User::className(), ['user_id' => 'updated_by']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => \Yii::$app->user->identity->user_id,
            ],
        ];
    }

    function getStatusOptions() {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'In-Active'
        ];
    }

    function getStatusName() {
        $status = $this->getStatusOptions();
        if (isset($status[$this->is_active])) {
            return $status[$this->is_active];
        }
        return NULL;
    }

}
