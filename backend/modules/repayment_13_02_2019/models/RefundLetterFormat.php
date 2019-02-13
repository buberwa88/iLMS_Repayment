<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_letter_format".
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
 * @property RefundApplicationInternalOperation[] $refundApplicationInternalOperations
 * @property User $createdBy
 * @property User $updatedBy
 */
class RefundLetterFormat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_letter_format';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['letter_body'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_active'], 'integer'],
            [['letter_name', 'header', 'footer'], 'string', 'max' => 200],
            [['letter_heading'], 'string', 'max' => 50],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_letter_format_id' => 'Refund Letter Format ID',
            'letter_name' => 'Letter Name',
            'header' => 'Header',
            'footer' => 'Footer',
            'letter_heading' => 'Letter Heading',
            'letter_body' => 'Letter Body',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationInternalOperations()
    {
        return $this->hasMany(RefundApplicationInternalOperation::className(), ['refund_letter_format_id' => 'refund_letter_format_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }
}
