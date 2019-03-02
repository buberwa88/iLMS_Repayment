<?php

namespace backend\modules\repayment\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "refund_status_reason_setting".
 *
 * @property integer $refund_status_reason_setting_id
 * @property integer $status
 * @property string $reason
 * @property integer $category
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\repayment\models\RefundApplicationProgress[] $refundApplicationProgresses
 * @property \backend\modules\repayment\models\User $createdBy
 * @property \backend\modules\repayment\models\User $updatedBy
 */
class RefundStatusReasonSetting extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames() {
        return [
            'refundApplicationProgresses',
            'createdBy',
            'updatedBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['status', 'category', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['reason'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'refund_status_reason_setting';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'refund_status_reason_setting_id' => 'Refund Status Reason Setting ID',
            'status' => 'Status Type',
            'reason' => 'Comment',
            'category' => 'Reason Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationProgresses() {
        return $this->hasMany(\backend\modules\repayment\models\RefundApplicationProgress::className(), ['refund_status_reason_setting_id' => 'refund_status_reason_setting_id']);
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

}
