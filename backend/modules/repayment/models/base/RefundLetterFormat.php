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
class RefundLetterFormat extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'refundApplicationOperationLetters',
            'createdBy',
            'updatedBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['letter_body'], 'string'],
            [['created_at', 'updated_at','letter_code'], 'safe'],
            [['created_by', 'updated_by', 'is_active'], 'integer'],
            [['letter_name', 'header', 'footer'], 'string', 'max' => 200],
            [['letter_heading'], 'string', 'max' => 50]
        ];
    }

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
    public function attributeLabels()
    {
        return [
            'refund_letter_format_id' => 'Refund Letter Format ID',
            'letter_name' => 'Letter Name',
            'header' => 'Header',
            'footer' => 'Footer',
            'letter_heading' => 'Letter Heading',
            'letter_body' => 'Letter Body',
            'is_active' => 'Is Active',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationOperationLetters()
    {
        return $this->hasMany(\backend\modules\repayment\models\RefundApplicationOperationLetter::className(), ['refund_letter_format_id' => 'refund_letter_format_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\backend\modules\repayment\models\User::className(), ['user_id' => 'created_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\backend\modules\repayment\models\User::className(), ['user_id' => 'updated_by']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
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
